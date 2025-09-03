<?php

namespace App\Http\Controllers;

use App\Models\PendingAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PendingAppointmentController extends Controller
{
    // Display the list of pending appointments with pagination
    public function index()
    {
        $appointments = PendingAppointment::where('status', 'Pending')
            ->with(['instructor', 'pendingMembership'])
            ->orderBy('id', 'desc') // Order by 'id' in descending order
            ->paginate(10);
        return view('appointment-pending-list', compact('appointments'));
    }

    // Store a new appointment and validate the incoming request
    public function store(Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'user_id' => 'required|exists:pending_memberships,id',  // Check pending_memberships table
            'selected_date' => 'required|date',
            'selected_time' => 'required',
            'payment_method' => 'nullable|string',
            'gcash_account_name' => 'nullable|string|max:255',
            'gcash_account_number' => 'nullable|string|max:20',
            'proof_of_payment' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048', // Accept image or PDF
            'status' => 'string|in:Pending,Approved,Declined',
            'instructor_rate' => 'nullable|numeric|min:0',
            'gym_rate' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            $data = $request->all();

            // Handle proof of payment upload if exists
            if ($request->hasFile('proof_of_payment')) {
                $data['proof_of_payment'] = $request->file('proof_of_payment')->store('proofs', 'public');
            }

            // Create the appointment
            $appointment = PendingAppointment::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully.',
                'data' => $appointment,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create appointment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Approve a pending appointment
    public function approve($id)
    {
        $appointment = PendingAppointment::findOrFail($id);
        $appointment->status = 'Approved';
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment approved successfully.');
    }

    // Decline a pending appointment
    public function decline($id)
    {
        $appointment = PendingAppointment::findOrFail($id);
        $appointment->status = 'Declined';
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment declined successfully.');
    }

    // Display the list of confirmed and declined appointments
    public function appointmentList()
    {
        $appointments = PendingAppointment::whereIn('status', ['Approved', 'Declined'])
            ->with(['instructor', 'pendingMembership'])
            ->orderBy('id', 'desc') // Order by 'id' in descending order
            ->paginate(10);

        // Calculate totals only for approved appointments
        $approvedAppointments = PendingAppointment::where('status', 'Approved')->get();

        $totalInstructorRate = $approvedAppointments->sum('instructor_rate') ?? 0;
        $totalGymRate = $approvedAppointments->sum('gym_rate') ?? 0;
        $totalAmount = $approvedAppointments->sum('total_amount') ?? 0;
        $totalAppointments = $approvedAppointments->count();

        $date = null; // Default date for index view
        return view('appointment-list', compact('appointments', 'totalInstructorRate', 'totalGymRate', 'totalAmount', 'totalAppointments', 'date'));
    }

    // Show a specific appointment by ID
    public function show($id)
    {
        $appointment = PendingAppointment::with(['instructor', 'pendingMembership'])->findOrFail($id);
        return response()->json($appointment);
    }

    // List appointments with optional filters via query parameters
    public function list(Request $request)
    {
        $query = PendingAppointment::query();

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $appointments = $query->get();

        return response()->json($appointments);
    }

    // Update a specific appointment
    public function update(Request $request, $id)
    {
        $request->validate([
            'instructor_id' => 'exists:instructors,id',
            'user_id' => 'exists:pending_memberships,id',
            'selected_date' => 'date',
            'selected_time' => 'string',
            'payment_method' => 'nullable|string',
            'gcash_account_name' => 'nullable|string|max:255',
            'gcash_account_number' => 'nullable|string|max:20',
            'proof_of_payment' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048', // Accept image or PDF
            'status' => 'string|in:Pending,Approved,Declined',
            'instructor_rate' => 'nullable|numeric|min:0',
            'gym_rate' => 'nullable|numeric|min:0',
            'total_amount' => 'nullable|numeric|min:0',
        ]);

        try {
            $appointment = PendingAppointment::findOrFail($id);
            $data = $request->all();

            // Handle proof of payment upload if exists
            if ($request->hasFile('proof_of_payment')) {
                // Delete old file if exists
                if ($appointment->proof_of_payment) {
                    Storage::disk('public')->delete($appointment->proof_of_payment);
                }
                $data['proof_of_payment'] = $request->file('proof_of_payment')->store('proofs', 'public');
            }

            $appointment->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Appointment updated successfully.',
                'data' => $appointment,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update appointment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Move selected appointments to trash (soft delete)
    public function moveToTrash(Request $request)
    {
        $appointmentIds = explode(',', $request->input('selected', ''));

        if (empty($appointmentIds)) {
            return redirect()->route('appointments.index')->with('error', 'No appointments selected.');
        }

        try {
            PendingAppointment::whereIn('id', $appointmentIds)->delete();

            return redirect()->route('appointments.index')->with('success', 'Selected appointments moved to trash.');
        } catch (\Exception $e) {
            return redirect()->route('appointments.index')->with('error', 'Failed to move appointments to trash.');
        }
    }

    // Display trashed appointments
    public function trashed()
    {
        $trashedAppointments = PendingAppointment::onlyTrashed()->paginate(10); // Use pagination
        return view('trashed-appointment-pending-list', compact('trashedAppointments'));
    }

    // Restore selected bulk appointments from trash
    public function restoreBulk(Request $request)
    {
        $appointmentIds = explode(',', $request->input('selected'));

        // Restore the selected appointments
        PendingAppointment::onlyTrashed()->whereIn('id', $appointmentIds)->restore();

        return redirect()->route('appointments.pending.trashed')->with('success', 'Appointments restored successfully.');
    }

    // Restore a single appointment from trash
    public function restore($id)
    {
        $appointment = PendingAppointment::onlyTrashed()->findOrFail($id);
        $appointment->restore();

        return redirect()->route('appointments.pending.trashed')->with('success', 'Appointments restored successfully.');
    }

    // Permanently delete a single appointment from trash
    public function forceDelete($id)
    {
        $appointment = PendingAppointment::onlyTrashed()->findOrFail($id);
        $appointment->forceDelete();

        // Redirect to trashed list or any other appropriate route
        return redirect()->route('appointments.pending.trashed')->with('success', 'Appointment permanently deleted.');
    }

    // Method to handle the delete request
    public function destroy($id)
    {
        // Find the appointment by ID, including trashed ones if needed
        $appointment = PendingAppointment::withTrashed()->find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        try {
            // Force delete the appointment
            $appointment->forceDelete();

            return response()->json(['message' => 'Appointment successfully deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete the appointment', 'error' => $e->getMessage()], 500);
        }
    }

    // Filter appointments by date
    public function filterByDate(Request $request)
    {
        $date = $request->input('date');

        $appointments = PendingAppointment::whereIn('status', ['Approved', 'Declined'])
            ->whereDate('selected_date', $date)
            ->with(['instructor', 'pendingMembership'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Calculate totals only for approved appointments from the filtered date
        $approvedAppointments = PendingAppointment::where('status', 'Approved')
            ->whereDate('selected_date', $date)
            ->get();

        $totalInstructorRate = $approvedAppointments->sum('instructor_rate') ?? 0;
        $totalGymRate = $approvedAppointments->sum('gym_rate') ?? 0;
        $totalAmount = $approvedAppointments->sum('total_amount') ?? 0;
        $totalAppointments = $approvedAppointments->count();

        return view('appointment-list', compact('appointments', 'totalInstructorRate', 'totalGymRate', 'totalAmount', 'totalAppointments', 'date'));
    }

    // Export appointments to PDF by date
    public function exportPdfByDate(Request $request)
    {
        $date = $request->input('date');

        // Get appointments for the selected date or all if no date provided
        if ($date) {
            $appointments = PendingAppointment::whereIn('status', ['Approved', 'Declined'])
                ->whereDate('selected_date', $date)
                ->with(['instructor', 'pendingMembership'])
                ->get();
        } else {
            $appointments = PendingAppointment::whereIn('status', ['Approved', 'Declined'])
                ->with(['instructor', 'pendingMembership'])
                ->get();
        }

        // Calculate totals only for approved appointments
        $approvedAppointments = $appointments->where('status', 'Approved');
        $totalInstructorRate = $approvedAppointments->sum('instructor_rate') ?? 0;
        $totalGymRate = $approvedAppointments->sum('gym_rate') ?? 0;
        $totalAmount = $approvedAppointments->sum('total_amount') ?? 0;
        $totalAppointments = $approvedAppointments->count();

        // Generate the PDF
        $pdf = Pdf::loadView('appointment-pdf', [
            'appointments' => $appointments,
            'date' => $date,
            'totalInstructorRate' => $totalInstructorRate,
            'totalGymRate' => $totalGymRate,
            'totalAmount' => $totalAmount,
            'totalAppointments' => $totalAppointments,
        ]);

        // Return the PDF for download
        return $pdf->download('appointments-report.pdf');
    }
}
