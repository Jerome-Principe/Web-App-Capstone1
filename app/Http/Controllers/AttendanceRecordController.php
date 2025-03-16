<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceRecord;

class AttendanceRecordController extends Controller
{
    public function index()
    {
        // Fetch all attendance records in descending order by ID
        $attendanceRecords = AttendanceRecord::orderBy('id', 'desc')->get();

        // Pass the data to the view
        return view('attendance-record-list', compact('attendanceRecords'));
    }
}
