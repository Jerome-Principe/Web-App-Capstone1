<?php

namespace App\Http\Controllers;

use App\Models\CancelledAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CancelledAppointmentController extends Controller
{
    public function index()
    {
        $cancelledAppointments = CancelledAppointment::with('user')->paginate(10);

        return view('appointment-cancelled', compact('cancelledAppointments'));
    }

    // Add method to show proof of payment
    public function showProof($id)
    {
        try {
            $appointment = CancelledAppointment::findOrFail($id);

            if (!$appointment->proof_of_payment) {
                return response()->json(['error' => 'No proof of payment found'], 404);
            }

            // Debug: Log the proof_of_payment path
            \Log::info('Proof of payment path: ' . $appointment->proof_of_payment);

            // Check if file exists in public storage
            if (!Storage::disk('public')->exists($appointment->proof_of_payment)) {
                \Log::error('File not found in public storage: ' . $appointment->proof_of_payment);
                return response()->json(['error' => 'File not found in storage'], 404);
            }

            // Get the file path and return the file
            $filePath = Storage::disk('public')->path($appointment->proof_of_payment);
            $fileName = basename($appointment->proof_of_payment);

            // Debug: Log the actual file path
            \Log::info('Actual file path: ' . $filePath);

            // Check if file exists on disk
            if (!file_exists($filePath)) {
                \Log::error('File does not exist on disk: ' . $filePath);
                return response()->json(['error' => 'File not found on disk'], 404);
            }

            return response()->download($filePath, $fileName);
        } catch (\Exception $e) {
            \Log::error('Error in showProof: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve proof of payment: ' . $e->getMessage()], 500);
        }
    }

    // Add method to get proof of payment URL
    public function getProofUrl($id)
    {
        try {
            $appointment = CancelledAppointment::findOrFail($id);

            if (!$appointment->proof_of_payment) {
                return response()->json(['error' => 'No proof of payment found'], 404);
            }

            // Generate the proper storage URL
            $url = Storage::disk('public')->url($appointment->proof_of_payment);

            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get proof URL'], 500);
        }
    }

    // Alternative method to serve proof of payment (might resolve 403 error)
    public function serveProof($id)
    {
        try {
            $appointment = CancelledAppointment::findOrFail($id);

            if (!$appointment->proof_of_payment) {
                abort(404, 'No proof of payment found');
            }

            // Check if file exists
            if (!Storage::disk('public')->exists($appointment->proof_of_payment)) {
                abort(404, 'File not found');
            }

            // Get file info
            $filePath = Storage::disk('public')->path($appointment->proof_of_payment);
            $fileName = basename($appointment->proof_of_payment);
            $mimeType = Storage::disk('public')->mimeType($appointment->proof_of_payment);

            // Return file response with proper headers
            return response()->file($filePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="' . $fileName . '"'
            ]);
        } catch (\Exception $e) {
            abort(500, 'Failed to serve proof of payment');
        }
    }

    // Test method to debug storage issues
    public function testStorage($id)
    {
        try {
            $appointment = CancelledAppointment::findOrFail($id);

            $debugInfo = [
                'appointment_id' => $id,
                'proof_of_payment' => $appointment->proof_of_payment,
                'storage_path' => Storage::disk('public')->path($appointment->proof_of_payment ?? ''),
                'storage_url' => Storage::disk('public')->url($appointment->proof_of_payment ?? ''),
                'file_exists' => Storage::disk('public')->exists($appointment->proof_of_payment ?? ''),
                'disk_exists' => file_exists(Storage::disk('public')->path($appointment->proof_of_payment ?? '')),
                'public_path' => public_path('storage'),
                'storage_path_full' => storage_path('app/public'),
            ];

            return response()->json($debugInfo);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Simple redirect method for viewing proof (might work better)
    public function viewProof($id)
    {
        try {
            $appointment = CancelledAppointment::findOrFail($id);

            if (!$appointment->proof_of_payment) {
                abort(404, 'No proof of payment found');
            }

            // Generate the storage URL and redirect to it
            $url = Storage::disk('public')->url($appointment->proof_of_payment);

            return redirect($url);
        } catch (\Exception $e) {
            abort(500, 'Failed to get proof URL');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'instructor_name' => 'required|string|max:255',
            'selected_date' => 'required|string', // Accept string to handle single-digit dates
            'selected_time' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'proof_of_payment' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048', // Accept image or PDF
            'reason' => 'required|string|max:255',
        ]);

        try {
            // Parse and format the date to Y-m-d
            $formattedDate = Carbon::parse($request->selected_date)->format('Y-m-d');

            // Parse and format the time to H:i:s
            $formattedTime = Carbon::createFromFormat('g:i A', $request->selected_time)->format('H:i:s');

            // Handle proof of payment upload if exists
            $proofOfPaymentPath = null;
            if ($request->hasFile('proof_of_payment')) {
                $proofOfPaymentPath = $request->file('proof_of_payment')->store('proofs', 'public');
            }

            // Save the cancellation record
            $cancelledAppointment = new CancelledAppointment();
            $cancelledAppointment->user_id = $request->user_id;
            $cancelledAppointment->instructor_name = $request->instructor_name;
            $cancelledAppointment->selected_date = $formattedDate;
            $cancelledAppointment->selected_time = $formattedTime;
            $cancelledAppointment->payment_method = $request->payment_method;
            $cancelledAppointment->proof_of_payment = $proofOfPaymentPath;
            $cancelledAppointment->reason = $request->reason;
            $cancelledAppointment->save();

            // Ensure response matches the frontend expectation
            return response()->json([
                'status' => 'success',
                'message' => 'Cancellation submitted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error submitting cancellation.',
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function fetchCancelledAppointments()
    {
        try {
            $cancelledAppointments = CancelledAppointment::all();
            return response()->json($cancelledAppointments, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch canceled appointments', 'message' => $e->getMessage()], 500);
        }
    }

    // Move selected appointments to trash (soft delete)
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected')); // Parse the selected IDs
        if (!empty($selectedIds)) {
            CancelledAppointment::whereIn('id', $selectedIds)->delete(); // Soft delete the selected appointments
            return redirect()->route('appointments.cancelled') // Correct route name
                ->with('success', 'Selected appointments moved to trash.'); // Success message
        }

        return redirect()->back()->with('error', 'No appointments selected.'); // Error message if no IDs are selected
    }

    // Display trashed appointments
    public function trashed()
    {

        $trashedAppointments = CancelledAppointment::onlyTrashed()->paginate(10); // Use pagination

        return view('trashed-appointment-cancelled', compact('trashedAppointments'));
    }

    // Restore selected bulk appointments from trash
    public function restoreBulk(Request $request)
    {
        $appointmentIds = explode(',', $request->input('selected'));

        if (empty($appointmentIds)) {
            return back()->with('error', 'Please select at least one appointment to restore.');
        }

        try {
            // Restore the selected appointments
            CancelledAppointment::onlyTrashed()->whereIn('id', $appointmentIds)->restore();

            // Redirect to the cancelled appointments page with a success message
            return redirect()->route('appointments.cancelled.trashed')->with('success', 'Selected appointments restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore selected appointments.');
        }
    }

    // Restore a single appointment from trash
    public function restore($id)
    {
        try {
            $appointment = CancelledAppointment::onlyTrashed()->findOrFail($id);
            $appointment->restore();

            return redirect()->route('appointments.cancelled.trashed')->with('success', 'Appointment restored successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore the appointment.');
        }
    }

    // Permanently delete a single appointment from trash
    public function forceDelete($id)
    {
        try {
            $appointment = CancelledAppointment::onlyTrashed()->findOrFail($id);
            $appointment->forceDelete();

            return redirect()->route('appointments.cancelled.trashed')->with('success', 'Appointment permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the appointment.');
        }
    }
}
