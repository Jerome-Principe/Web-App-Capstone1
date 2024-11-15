<?php

namespace App\Http\Controllers;

use App\Models\PendingAppointment;
use Illuminate\Http\Request;

class PendingAppointmentController extends Controller
{
    public function index()
    {
        // Fetch only the appointments with status 'Pending'
        $appointments = PendingAppointment::where('status', 'Pending')->with(['instructor', 'user'])->get();
        return view('appointment-pending-list', compact('appointments'));
    }


    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'instructor_id' => 'required|exists:instructors,id',
            'user_id' => 'required|exists:pending_memberships,id',  // Change to check pending_memberships table
            'selected_date' => 'required|date',
            'selected_time' => 'required',
            'status' => 'string|in:Pending,Confirmed,Cancelled',
        ]);

        // Create the appointment
        try {
            $appointment = PendingAppointment::create($request->all());

            // Respond with the created appointment as JSON
            return response()->json([
                'success' => true,
                'message' => 'Appointment created successfully.',
                'data' => $appointment
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create appointment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approve($id)
    {
        $appointment = PendingAppointment::findOrFail($id);
        $appointment->status = 'Confirmed';
        $appointment->save();

        return redirect()->route('appointments.index')->with('success', 'Appointment approved successfully.');
    }

    public function decline($id)
    {
        $appointment = PendingAppointment::findOrFail($id);
        $appointment->status = 'Cancelled';
        $appointment->save();

        return redirect()->route('appointments.index')->with('error', 'Appointment declined.');
    }


    public function appointmentList()
    {
        // Fetch the confirmed appointments (where status is confirmed)
        $appointments = PendingAppointment::where('status', 'Confirmed')->with(['instructor', 'user'])->get();

        return view('appointment-list', compact('appointments'));
    }

    public function show($id)
    {
        // Find appointment by ID
        $appointment = PendingAppointment::with(['instructor', 'user'])->findOrFail($id);
        return response()->json($appointment);
    }

    public function update(Request $request, $id)
    {
        // Validate the request
        $request->validate([
            'instructor_id' => 'exists:instructors,id',
            'user_id' => 'exists:users,id',
            'selected_date' => 'date',
            'selected_time' => 'string',
            'status' => 'string|in:Pending,Confirmed,Cancelled',
        ]);

        // Find and update the appointment
        $appointment = PendingAppointment::findOrFail($id);
        $appointment->update($request->all());

        return response()->json($appointment);
    }

    public function destroy($id)
    {
        // Find and delete the appointment
        $appointment = PendingAppointment::findOrFail($id);
        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted successfully']);
    }

}
