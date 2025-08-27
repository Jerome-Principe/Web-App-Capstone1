<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\DB;

class AttendanceRecordController extends Controller
{
    public function index()
    {
        try {
            // Use chunking to process large datasets efficiently
            // This prevents loading all records into memory at once
            $attendanceRecords = collect();

            AttendanceRecord::orderBy('id', 'desc')
                ->chunk(100, function ($records) use ($attendanceRecords) {
                    foreach ($records as $record) {
                        $attendanceRecords->push($record);
                    }
                });

            // Disconnect to free database connections after processing
            DB::disconnect('mysql');

            // Pass the data to the view
            return view('attendance-record-list', compact('attendanceRecords'));

        } catch (\Exception $e) {
            // Handle database connection errors gracefully
            \Log::error('Database connection error in AttendanceRecordController: ' . $e->getMessage());

            // Return empty collection to prevent crashes
            $attendanceRecords = collect();
            return view('attendance-record-list', compact('attendanceRecords'))
                ->with('error', 'Unable to load attendance records. Please try again later.');
        }
    }
}
