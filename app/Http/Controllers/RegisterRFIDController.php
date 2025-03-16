<?php

namespace App\Http\Controllers;

use App\Models\RegisterRFID;
use Illuminate\Http\Request;

class RegisterRFIDController extends Controller
{
    public function index()
    {
        $registerRfids = RegisterRFID::paginate(10);
        $approvedMembers = \App\Models\PendingMembership::where('status', 'Approved')->get();
        return view('attendance-register-list', compact('registerRfids', 'approvedMembers'));
    }


    public function create()
    {
        return view('attendance-register-create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:pending_memberships,id',
            'username' => 'required|string|max:255',
            'serial_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        // Check if the serial number already exists
        if (RegisterRFID::where('serial_number', $request->serial_number)->exists()) {
            return redirect()->back()->with('error', 'Duplicate entry! Serial Number already taken.');
        } elseif (RegisterRFID::where('email', $request->email)->exists()) {
            return redirect()->back()->with('error', 'Duplicate entry! Email is already registered.');
        } elseif (RegisterRFID::create($validated)) {
            return redirect()->route('register-rfid.index')->with('success', 'RFID registered successfully.');
        }

        return redirect()->back()->with('error', 'An unexpected error occurred while registering the RFID.');
    }


    public function destroy($id)
    {
        $registerRfid = RegisterRFID::findOrFail($id);
        $registerRfid->delete();
        return redirect()->route('register-rfid.index')->with('success', 'RFID record deleted successfully.');
    }
}
