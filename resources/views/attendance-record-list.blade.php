<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

    <title>Attendance Record List</title>

    <style>
        /* Minimalist Global Styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #fafafa;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .main-wrapper {
            max-width: 1600px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        /* Minimalist Card Styles */
        .content-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 40px;
            margin-bottom: 32px;
            border: 1px solid #e1e5e9;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 10px;
            text-align: center;
            background: white;
            border: 1px solid #e1e5e9;
        }

        .clock {
            font-size: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            margin: 0 auto 20px auto;
            border-radius: 12px;
            text-align: center;
            width: fit-content;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            font-weight: 600;
            letter-spacing: 2px;
        }

        .date-display {
            text-align: center;
            font-size: 18px;
            color: #666;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .instruction-text {
            text-align: center;
            font-size: 16px;
            color: #555;
            margin: 0;
            line-height: 1.5;
        }

        /* Minimalist Table Styles */
        .table-section h2 {
            font-size: 20px;
            font-weight: 500;
            color: #333;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e1e5e9;
        }

        .table-container {
            overflow-x: auto;
            border: 1px solid #e1e5e9;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            background: #f8f9fa;
            color: #333;
            font-weight: 500;
            padding: 16px 12px;
            text-align: center !important;
            border-bottom: 1px solid #e1e5e9;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            text-align: center !important;
        }

        /* Ensure all content inside cells is centered */
        td *,
        th * {
            text-align: center !important;
        }

        /* Center flex containers */
        td .d-flex,
        th .d-flex {
            justify-content: center !important;
            align-items: center !important;
        }

        /* Center badge elements */
        td .badge,
        th .badge {
            display: inline-block;
            text-align: center;
        }

        /* Center strong elements */
        td strong,
        th strong {
            text-align: center;
            display: block;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        /* Badge */
        .badge {
            background: #e9ecef;
            color: #495057;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge.bg-primary {
            background: #007bff !important;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-wrapper {
                padding: 20px 16px;
            }

            .content-card {
                padding: 24px 16px;
            }

            .container {
                padding: 16px;
                margin: 15px auto;
            }
        }
    </style>

    <script>
        function updateClock() {
            const now = new Date();
            const time = now.toLocaleTimeString();
            const date = now.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
            document.getElementById('clock').innerText = time;
            document.getElementById('date').innerText = date;
        }

        document.addEventListener("DOMContentLoaded", function () {
            setInterval(updateClock, 1000);

            const rfidInput = document.getElementById("rfid-input");
            rfidInput.focus();

            rfidInput.addEventListener("input", function () {
                if (rfidInput.value.length >= 10) {
                    document.getElementById("rfid-form").submit();
                }
            });
        });
    </script>

</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Clock Section -->
            <div class="content-card">
                <div class="clock" id="clock">00:00:00 AM</div>
                <div id="date" class="date-display">00/00/00</div>
                <p class="instruction-text">Place your RFID card on the reader to record your time in and time out</p>
            </div>

            <!-- Table section -->
            <div class="content-card">
                <div class="table-section">
                    <h2>Attendance Records</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>RFID Number</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Date Logged</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendanceRecords as $attendanceRecord)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">{{ $attendanceRecord->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $attendanceRecord->username }}</strong>
                                        </td>
                                        <td>{{ $attendanceRecord->rfid }}</td>
                                        <td>
                                            {{ $attendanceRecord->time_in ? \Carbon\Carbon::parse($attendanceRecord->time_in)->format('h:i A') : 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $attendanceRecord->time_out ? \Carbon\Carbon::parse($attendanceRecord->time_out)->format('h:i A') : 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $attendanceRecord->created_at ? $attendanceRecord->created_at->format('F d, Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>

@endsection