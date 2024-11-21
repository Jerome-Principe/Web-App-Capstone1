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
            'selected_date' => 'required|date_format:m-d-Y',
            'selected_time' => 'required|string',
            'payment_method' => 'required|string|max:255',
            'proof_of_payment' => 'required|string',
            'reason' => 'required|string|max:255',
        ]);

        try {
            // Format date and time
            $formattedDate = Carbon::createFromFormat('m-d-Y', $request->selected_date)->format('m-d-Y');
            $formattedTime = Carbon::createFromFormat('H:i:s', $request->selected_time)->format('H:i:s');

            // Store appointment
            $cancelledAppointment = new CancelledAppointment();
            $cancelledAppointment->user_id = $request->user_id;
            $cancelledAppointment->instructor_name = $request->instructor_name;
            $cancelledAppointment->selected_date = $formattedDate;
            $cancelledAppointment->selected_time = $formattedTime;
            $cancelledAppointment->payment_method = $request->payment_method;
            $cancelledAppointment->proof_of_payment = $request->proof_of_payment; // Save the proof of payment path
            $cancelledAppointment->reason = $request->reason;
            $cancelledAppointment->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Cancellation submitted successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error submitting cancellation.',
                'exception' => $e->getMessage(),
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
