<?php

namespace App\Http\Controllers;

use App\Models\CancelledAppointment;
use Illuminate\Http\Request;
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
            'selected_date' => 'required|date_format:m/d/Y',
            'selected_time' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'proof_of_payment' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048', // Accept image or PDF
            'reason' => 'required|string|max:255',
        ]);

        try {
            $data = $request->all();

            // Handle proof of payment upload if exists
            if ($request->hasFile('proof_of_payment')) {
                $data['proof_of_payment'] = $request->file('proof_of_payment')->store('proofs', 'public');
            }

            // Create the appointment
            $appointment = CancelledAppointment::create($data);

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

    public function fetchCancelledAppointments()
    {
        try {
            $cancelledAppointments = CancelledAppointment::all(); // Or apply filters if needed
            return response()->json($cancelledAppointments, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch canceled appointments', 'message' => $e->getMessage()], 500);
        }
    }


}
