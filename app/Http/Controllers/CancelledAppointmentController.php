<?php

namespace App\Http\Controllers;

use App\Models\CancelledAppointment;
use Illuminate\Http\Request;

class CancelledAppointmentController extends Controller
{
    public function index()
    {
        $cancelledAppointments = CancelledAppointment::with('user')->paginate(10);

        return view('appointment-cancelled', compact('cancelledAppointments'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'instructor_name' => 'required|string|max:255',
            'selected_date' => 'required|date',
            'selected_time' => 'required',
            'payment_method' => 'required|string|max:255',
            'reason' => 'required|string|max:500',
        ]);

        $cancelledAppointment = CancelledAppointment::create($validatedData);

        return response()->json([
            'message' => 'Appointment cancelled successfully.',
            'data' => $cancelledAppointment,
        ], 201);
    }

}
