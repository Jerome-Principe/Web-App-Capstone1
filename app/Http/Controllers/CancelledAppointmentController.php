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

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'instructor_name' => 'required|string|max:255',
            'selected_date' => 'required|string',
            'selected_time' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'proof_of_payment' => 'nullable|string|max:255',
            'reason' => 'required|string|max:255',
        ]);

        try {
            // Parse and format the date to Y-m-d
            $formattedDate = Carbon::parse($request->selected_date)->format('Y-m-d');

            // Parse and format the time to H:i:s
            $formattedTime = null;
            try {
                // Try different time formats
                if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $request->selected_time)) {
                    // Already in H:i:s format
                    $formattedTime = $request->selected_time;
                } elseif (preg_match('/^\d{1,2}:\d{2} [AP]M$/', $request->selected_time)) {
                    // g:i A format (e.g., "6:00 AM")
                    $formattedTime = Carbon::createFromFormat('g:i A', $request->selected_time)->format('H:i:s');
                } else {
                    // Default to original time if parsing fails
                    $formattedTime = $request->selected_time;
                }
            } catch (\Exception $e) {
                // If parsing fails, use original time
                $formattedTime = $request->selected_time;
            }

            // Handle proof of payment (can be a string path or file upload)
            $proofOfPaymentPath = null;
            if ($request->hasFile('proof_of_payment')) {
                // Handle file upload
                $proofOfPaymentPath = $request->file('proof_of_payment')->store('proofs', 'public');
            } elseif ($request->filled('proof_of_payment')) {
                // Handle string value (e.g., from mobile app)
                $proofOfPaymentPath = $request->proof_of_payment;
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
        $selectedIds = explode(',', $request->input('selected'));
        if (!empty($selectedIds)) {
            CancelledAppointment::whereIn('id', $selectedIds)->delete();
            return redirect()->route('appointments.cancelled')
                ->with('success', 'Selected appointments moved to trash.');
        }

        return redirect()->back()->with('error', 'No appointments selected.');
    }

    // Display trashed appointments
    public function trashed()
    {
        $trashedAppointments = CancelledAppointment::onlyTrashed()->paginate(10);

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
            CancelledAppointment::onlyTrashed()->whereIn('id', $appointmentIds)->restore();

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

    // View proof of payment for cancelled appointment
    public function viewProof($id)
    {
        try {
            $cancelledAppointment = CancelledAppointment::findOrFail($id);

            if (!$cancelledAppointment->proof_of_payment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No proof of payment found for this appointment.'
                ], 404);
            }

            // Check if file exists in storage
            if (!Storage::disk('public')->exists($cancelledAppointment->proof_of_payment)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Proof of payment file not found.'
                ], 404);
            }

            // Get file path and return file
            $filePath = storage_path('app/public/' . $cancelledAppointment->proof_of_payment);

            if (file_exists($filePath)) {
                return response()->file($filePath);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'File not accessible.'
            ], 500);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error viewing proof of payment: ' . $e->getMessage()
            ], 500);
        }
    }

    // Show proof of payment (alternative method)
    public function showProof($id)
    {
        try {
            $cancelledAppointment = CancelledAppointment::findOrFail($id);

            if (!$cancelledAppointment->proof_of_payment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No proof of payment found for this appointment.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $cancelledAppointment->id,
                    'proof_of_payment' => $cancelledAppointment->proof_of_payment,
                    'file_url' => Storage::disk('public')->url($cancelledAppointment->proof_of_payment)
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error showing proof of payment: ' . $e->getMessage()
            ], 500);
        }
    }

    // Get proof URL
    public function getProofUrl($id)
    {
        try {
            $cancelledAppointment = CancelledAppointment::findOrFail($id);

            if (!$cancelledAppointment->proof_of_payment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No proof of payment found for this appointment.'
                ], 404);
            }

            $url = Storage::disk('public')->url($cancelledAppointment->proof_of_payment);

            return response()->json([
                'status' => 'success',
                'url' => $url
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error getting proof URL: ' . $e->getMessage()
            ], 500);
        }
    }

    // Serve proof file
    public function serveProof($id)
    {
        try {
            $cancelledAppointment = CancelledAppointment::findOrFail($id);

            if (!$cancelledAppointment->proof_of_payment) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No proof of payment found for this appointment.'
                ], 404);
            }

            if (!Storage::disk('public')->exists($cancelledAppointment->proof_of_payment)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Proof of payment file not found.'
                ], 404);
            }

            return Storage::disk('public')->response($cancelledAppointment->proof_of_payment);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error serving proof file: ' . $e->getMessage()
            ], 500);
        }
    }

    // Test storage connection
    public function testStorage($id)
    {
        try {
            $cancelledAppointment = CancelledAppointment::findOrFail($id);

            $storageInfo = [
                'disk' => 'public',
                'file_exists' => $cancelledAppointment->proof_of_payment ? Storage::disk('public')->exists($cancelledAppointment->proof_of_payment) : false,
                'file_path' => $cancelledAppointment->proof_of_payment,
                'full_path' => $cancelledAppointment->proof_of_payment ? storage_path('app/public/' . $cancelledAppointment->proof_of_payment) : null,
                'file_size' => $cancelledAppointment->proof_of_payment ? Storage::disk('public')->size($cancelledAppointment->proof_of_payment) : null,
                'storage_url' => $cancelledAppointment->proof_of_payment ? Storage::disk('public')->url($cancelledAppointment->proof_of_payment) : null
            ];

            return response()->json([
                'status' => 'success',
                'storage_info' => $storageInfo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error testing storage: ' . $e->getMessage()
            ], 500);
        }
    }
}
