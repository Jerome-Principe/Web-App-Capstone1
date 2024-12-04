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
            'selected_date' => 'required|string', // Accept string to handle single-digit dates
            'selected_time' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'proof_of_payment' => 'required|string',
            'reason' => 'required|string|max:255',
        ]);

        try {
            // Parse and format the date to Y-m-d
            $formattedDate = Carbon::parse($request->selected_date)->format('Y-m-d');

            // Parse and format the time to H:i:s
            $formattedTime = Carbon::createFromFormat('g:i A', $request->selected_time)->format('H:i:s');

            // Save the cancellation record
            $cancelledAppointment = new CancelledAppointment();
            $cancelledAppointment->user_id = $request->user_id;
            $cancelledAppointment->instructor_name = $request->instructor_name;
            $cancelledAppointment->selected_date = $formattedDate;
            $cancelledAppointment->selected_time = $formattedTime;
            $cancelledAppointment->payment_method = $request->payment_method;
            $cancelledAppointment->proof_of_payment = $request->proof_of_payment;
            $cancelledAppointment->reason = $request->reason;
            $cancelledAppointment->save();

            // Ensure response matches the frontend expectation
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
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));
        if (!empty($selectedIds)) {
            CancelledAppointment::whereIn('id', $selectedIds)->delete();
            return redirect()->route('appointments.trashed')->with('success', 'Selected appointments moved to trash.');
        }

        return redirect()->back()->with('error', 'No appointments selected.');
    }


    // Display trashed appointments
    public function trashed()
    {

        $trashedAppointments = CancelledAppointment::onlyTrashed()->paginate(10); // Use pagination

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
            return back()->with('success', 'Selected appointments restored successfully.');
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

            return back()->with('success', 'Appointment restored successfully.');
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

            return back()->with('success', 'Appointment permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the appointment.');
        }
    }
}
