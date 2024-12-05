<?php

namespace App\Http\Controllers;

use App\Models\PendingAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendingAppointmentController extends Controller
{
    // Display the list of pending appointments with pagination
    public function index()
    {
        $appointments = PendingAppointment::where('status', 'Pending')
            ->with(['instructor', 'pendingMembership'])
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

    public function cancel(Request $request, $appointmentId)
    {
        $appointment = PendingAppointment::findOrFail($appointmentId);

        // Update the status to 'Cancelled' and save the reason
        $appointment->status = 'Cancelled';
        $appointment->cancellation_reason = $request->reason;
        $appointment->save();

        return response()->json(['status' => 'success', 'message' => 'Appointment canceled successfully.']);
    }

    // Display the list of confirmed and declined appointments
    public function appointmentList()
    {
        $appointments = PendingAppointment::whereIn('status', ['Approved', 'Declined'])
            ->with(['instructor', 'pendingMembership'])
            ->paginate(10);

        return view('appointment-list', compact('appointments'));
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
        // Find the appointment by ID
        $appointment = PendingAppointment::find($id);

        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        // Delete the appointment
        $appointment->delete();

        return response()->json(['message' => 'Appointment successfully deleted'], 200);
    }
}
