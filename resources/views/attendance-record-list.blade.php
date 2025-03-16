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
        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            text-align: center;
        }

        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        .clock {
            font-size: 50px;
            background-color: rgba(194, 192, 192, 0.79);
            color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        button {
            margin-top: 10px;
            padding: 8px 16px;
            background-color: rgb(196, 44, 44);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: rgb(207, 88, 88);
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
        <div class="container">
            <div class="clock" id="clock">00:00:00 AM</div>
            <div id="date" class="mb-3">00/00/00</div>
            <p>Place your RFID card on the reader to record your time in and time out</p>
        </div>

        <!-- Table section -->
        <div class="container">
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
                            <td>{{ $attendanceRecord->id }}</td>
                            <td>{{ $attendanceRecord->username }}</td>
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
    </body>

@endsection