<?php

namespace App\Http\Controllers;

use App\Models\PendingAppointment;
use Illuminate\Http\Request;

class PendingAppointmentController extends Controller
{
    public function index()
    {
        $user = auth()->user(); // Get the currently authenticated user

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Fetch appointments for the logged-in user
        $appointments = PendingAppointment::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->with(['instructor', 'pendingMembership'])
            ->get();

        return response()->json($appointments);
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

        return redirect()->route('appointments.index')->with('success', 'Appointment declined successfully.');
    }

    public function appointmentList()
    {
        // Fetch both confirmed and declined appointments
        $appointments = PendingAppointment::whereIn('status', ['Confirmed', 'Cancelled'])
            ->with(['instructor', 'pendingMembership'])
            ->get();

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
