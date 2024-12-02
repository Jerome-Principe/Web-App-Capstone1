<?php

namespace App\Http\Controllers;

use App\Models\PendingAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PendingAppointmentController extends Controller
{
    public function index()
    {
        // Fetch only the appointments with status 'Pending'
        $appointments = PendingAppointment::where('status', 'Pending')
            ->with(['instructor', 'pendingMembership'])
            ->paginate(10);
        return view('appointment-pending-list', compact('appointments'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
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

    public function approve($id)
    {
        $appointment = PendingAppointment::findOrFail($id);
        $appointment->status = 'Approved';
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment approved successfully.');
    }

    public function decline($id)
    {
        $appointment = PendingAppointment::findOrFail($id);
        $appointment->status = 'Declined';
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment declined successfully.');
    }

    public function appointmentList()
    {
        // Fetch both confirmed and declined appointments
        $appointments = PendingAppointment::whereIn('status', ['Approved', 'Declined'])
            ->with(['instructor', 'pendingMembership'])
            ->paginate(10);

        return view('appointment-list', compact('appointments'));
    }

    public function show($id)
    {
        // Find appointment by ID
        $appointment = PendingAppointment::with(['instructor', 'pendingMembership'])->findOrFail($id);
        return response()->json($appointment);
    }

    public function list(Request $request)
    {
        // Optional filters can be applied via query parameters
        $query = PendingAppointment::query();

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        $appointments = $query->get();

        return response()->json($appointments);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
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

    // Add this method to delete an appointment in the PendingAppointmentController.php
    public function destroy($id)
    {
        try {
            $appointment = PendingAppointment::findOrFail($id);

            // Delete the appointment data
            $appointment->delete();

            return response()->json(['message' => 'Appointment deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete appointment.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function moveToTrash(Request $request)
    {
        $appointmentIds = explode(',', $request->input('selected', ''));

        if (empty($appointmentIds)) {
            return redirect()->route('appointments.index')->with('error', 'No appointments selected to move to trash.');
        }

        // Soft delete selected appointments
        PendingAppointment::whereIn('id', $appointmentIds)->delete();

        return redirect()->route('appointments.index')->with('success', 'Selected pending appointments moved to trash.');
    }


    public function trashed()
    {
        $trashedAppointments = PendingAppointment::onlyTrashed()->paginate(10); // Use pagination
        return view('trashed-appointment-pending-list', compact('trashedAppointments'));

    }
    public function restoreBulk(Request $request)
    {

        // Retrieve the selected Appointments IDs from the form
        $appointmentIds = explode(',', $request->input('selected'));

        // Restore the selected appointments
        PendingAppointment::onlyTrashed()->whereIn('id', $appointmentIds)->restore();

        return redirect()->route('appointments.index')->with('success', 'Appointments restored successfully.');
    }
    public function restore($id)
    {
        $appointment = PendingAppointment::onlyTrashed()->findOrFail($id);
        $appointment->restore();

        return redirect()->route('appointments.index')->with('success', 'Appointments restored successfully.');
    }

    public function forceDelete($id)
    {
        $appointment = PendingAppointment::onlyTrashed()->findOrFail($id);
        $appointment->forceDelete();

        return redirect()->route('appointments.trashed')->with('success', 'Appointments permanently deleted.');
    }
}