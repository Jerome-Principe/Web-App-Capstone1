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
        // Validate the incoming request data
        $request->validate([
            'user_id' => 'required|integer',
            'instructor_name' => 'required|string|max:255',
            'selected_date' => 'required|date_format:m/d/Y',
            'selected_time' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
        ]);

        try {
            // Convert the date to MySQL format (Y-m-d)
            $formattedDate = Carbon::createFromFormat('m/d/Y', $request->selected_date)->format('Y-m-d');

            // Convert the time to MySQL format (H:i:s)
            $formattedTime = Carbon::createFromFormat('g:i:s A', $request->selected_time)->format('H:i:s');

            // Create a new CancelledAppointment record
            $cancelledAppointment = new CancelledAppointment();
            $cancelledAppointment->user_id = $request->user_id;
            $cancelledAppointment->instructor_name = $request->instructor_name;
            $cancelledAppointment->selected_date = $formattedDate; // Save reformatted date
            $cancelledAppointment->selected_time = $formattedTime; // Save reformatted time
            $cancelledAppointment->payment_method = $request->payment_method;
            $cancelledAppointment->reason = $request->reason;
            $cancelledAppointment->save();

            return response()->json(['message' => 'Cancellation submitted successfully.'], 200);
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'message' => 'Error submitting cancellation.',
                'exception' => $e->getMessage()
            ], 500);
        }
    }

}
