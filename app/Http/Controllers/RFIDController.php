<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RFID;
use App\Models\RegisterRFID;
use App\Models\AttendanceRecord;
use Carbon\Carbon;

class RFIDController extends Controller
{
    public function index()
    {
        $timeIns = RFID::orderBy('id', 'desc')->get();
        $usernames = RegisterRFID::select('username')->get();
        return view('attendance', compact('timeIns', 'usernames')); // Pass usernames to the view

    }

    public function store(Request $request)
    {
        $request->validate([
            'rfid' => 'nullable|string|max:50', // For RFID Scan
            'username' => 'nullable|string',   // For Username Select
        ]);

        // Check if it's RFID scan or manual username entry
        if ($request->rfid) {
            // Handle RFID scan logic
            $rfid = $request->rfid;

            // Check if the RFID exists in RegisterRFID
            $registeredRFID = RegisterRFID::where('serial_number', $rfid)->first();

            if (!$registeredRFID) {
                return redirect()->back()->with('error', 'RFID not Registered!');
            }

            // Check if the RFID already exists in the Attendance table
            $existingRfid = RFID::where('rfid', $rfid)->first();

            if ($existingRfid) {
                // If RFID exists, mark as time-out and delete the existing entry
                AttendanceRecord::create([
                    'username' => $existingRfid->username,
                    'rfid' => $existingRfid->rfid,
                    'time_in' => $existingRfid->time_in,
                    'time_out' => now(),
                    'date_logged' => $existingRfid->date_logged,
                ]);

                // Delete the existing RFID entry (time-out marked)
                $existingRfid->delete();

                return redirect()->route('rfid.index')->with('success', 'Time Out Successfully!');
            }

            // If RFID doesn't exist yet, register time-in
            RFID::create([
                'username' => $registeredRFID->username,
                'rfid' => $rfid,
                'time_in' => Carbon::now('Asia/Manila'),
                'date_logged' => Carbon::now('Asia/Manila')->toDateString(),
            ]);

            return redirect()->route('rfid.index')->with('success', 'Time In Successfully!');
        }

        // Manual username logic (if RFID scan isn't used)
        if ($request->username) {
            $username = $request->username;

            // Check if username exists in RegisterRFID
            $registeredRFID = RegisterRFID::where('username', $username)->first();

            if (!$registeredRFID) {
                return redirect()->back()->with('error', 'User not found in RegisterRFID.');
            }

            $serialNumber = $registeredRFID->serial_number;

            // Check if the RFID (serial number) exists in the RFID table
            $existingRfid = RFID::where('rfid', $serialNumber)->first();

            if ($existingRfid) {
                // Save to attendance record with time-out
                AttendanceRecord::create([
                    'username' => $existingRfid->username,
                    'rfid' => $existingRfid->rfid,
                    'time_in' => $existingRfid->time_in,
                    'time_out' => now(),
                    'date_logged' => $existingRfid->date_logged,
                ]);

                // Delete the RFID entry after time-out
                $existingRfid->delete();

                return redirect()->route('rfid.index')->with('success', 'Time Out Successfully!');
            }

            // Register time-in if no existing record
            RFID::create([
                'username' => $username,
                'rfid' => $serialNumber,
                'time_in' => Carbon::now('Asia/Manila'),
                'date_logged' => Carbon::now('Asia/Manila')->toDateString(),
            ]);

            return redirect()->route('rfid.index')->with('success', 'Time In Successfully!');
        }
    }

    public function getAttendanceByUsername(Request $request)
    {
        $username = $request->query('username'); // Get the username from query parameters

        if (!$username) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        // Filter attendance and attendance records by the given username in descending order
        $attendance = RFID::where('username', $username)->orderBy('id', 'desc')->get();
        $attendanceRecord = AttendanceRecord::where('username', $username)->orderBy('id', 'desc')->get();

        return response()->json([
            'attendance' => $attendance,
            'attendanceRecord' => $attendanceRecord,
        ]);
    }

}
