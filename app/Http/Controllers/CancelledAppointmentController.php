<?php

namespace App\Http\Controllers;

use App\Models\CancelledAppointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
            'selected_date' => 'required|string',
            'selected_time' => 'required|string|max:255',
            'payment_method' => 'required|string|max:255',
            'proof_of_payment' => 'required|file|mimes:jpg,png,jpeg,pdf|max:2048',
            'reason' => 'required|string|max:255',
        ]);

        try {
            // Parse and format the date to Y-m-d
            $formattedDate = Carbon::parse($request->selected_date)->format('Y-m-d');

            // Parse and format the time to H:i:s
            $formattedTime = Carbon::createFromFormat('g:i A', $request->selected_time)->format('H:i:s');

            // Handle proof of payment upload if exists
            $proofOfPaymentPath = null;
            if ($request->hasFile('proof_of_payment')) {
                $proofOfPaymentPath = $request->file('proof_of_payment')->store('proofs', 'public');
            }

            // Save the cancellation record
            $cancelledAppointment = new CancelledAppointment();
            $cancelledAppointment->user_id = $request->user_id;
            $cancelledAppointment->instructor_name = $request->instructor_name;
            $cancelledAppointment->selected_date = $formattedDate;
            $cancelledAppointment->selected_time = $formattedTime;
            $cancelledAppointment->payment_method = $request->payment_method;
            $cancelledAppointment->proof_of_payment = $proofOfPaymentPath;
            $cancelledAppointment->reason = $request->reason;
            $cancelledAppointment->save();

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

    // Move selected appointments to trash (soft delete)
    public function moveToTrash(Request $request)
    {
        $selectedIds = explode(',', $request->input('selected'));
        if (!empty($selectedIds)) {
            CancelledAppointment::whereIn('id', $selectedIds)->delete();
            return redirect()->route('appointments.cancelled')
                ->with('success', 'Selected appointments moved to trash.');
        }

        return redirect()->back()->with('error', 'No appointments selected.');
    }

    // Display trashed appointments
    public function trashed()
    {
        $trashedAppointments = CancelledAppointment::onlyTrashed()->paginate(10);

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

            return redirect()->route('appointments.cancelled.trashed')->with('success', 'Selected appointments restored successfully.');
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

            return redirect()->route('appointments.cancelled.trashed')->with('success', 'Appointment restored successfully.');
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

            return redirect()->route('appointments.cancelled.trashed')->with('success', 'Appointment permanently deleted.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete the appointment.');
        }
    }
}
