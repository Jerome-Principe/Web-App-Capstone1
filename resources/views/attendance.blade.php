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

    <title>Attendance RFID</title>

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

        .input-box {
            margin: 20px auto;
            text-align: center;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            font-size: 20px;
            text-align: center;
        }

        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 100%;
            border: none !important;
            outline: none !important;
        }

        th,
        td {
            border: none;
            padding: 12px;
            text-align: center;
            border: none !important;
            outline: none !important;
            color: black !important;
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
                if (rfidInput.value.length >= 10) { // Adjust length as needed
                    document.getElementById("rfid-form").submit();
                }
            });
        });
    </script>

</head>

@extends('layouts.master')

@section('content')

    <div class="container">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                style="margin-bottom: 15px; min-width: 200px;">
                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                style="margin-bottom: 15px; min-width: 200px;">
                <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <script>
            setTimeout(function () {
                const alerts = document.querySelectorAll('.alert-dismissible');
                alerts.forEach(alert => {
                    alert.classList.remove('show'); // Hides the alert with Bootstrap's fade-out effect
                    alert.addEventListener('transitionend', () => alert.remove()); // Removes from DOM after fade-out
                });
            }, 3000); // 3000 milliseconds = 3 seconds
        </script>

        <!-- Clock and Date -->
        <div class="clock" id="clock">00:00:00 AM</div>
        <div id="date" class="mb-3">00/00/00</div>
        <p>Place your RFID card on the reader or enter your user ID to record your time in and time out</p>
    </div>

    <!-- Input Box -->
    <div class="input-box">
        <form id="rfid-form" action="{{ route('rfid.store') }}" method="POST">
            @csrf
            <input type="text" id="rfid-scan" name="rfid" placeholder="Scan your RFID" autofocus autocomplete="off"
                style="margin: 0.5rem;">

            <select id="user-id-input" name="username"
                style="margin: 0.5rem; padding: 0.5rem; width: 100%; max-width: 300px; height: 40px; border-radius: 5px; border: 1px solid #ccc;">
                <option value="" disabled selected>Select your username</option>
                @foreach($usernames as $user)
                    <option value="{{ $user->username }}">{{ $user->username }}</option>
                @endforeach
            </select>
            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Table Section -->
    <div class="container mt-4">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>RFID Number</th>
                    <th>Time In</th>
                    <th>Date Logged</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($timeIns as $timein)
                    <tr>
                        <td>{{ $timein->id }}</td>
                        <td>{{ $timein->username }}</td>
                        <td>{{ $timein->rfid }}</td>
                        <td>{{ \Carbon\Carbon::parse($timein->time_in)->timezone('Asia/Manila')->format('h:i A') }}</td>
                        <td>{{ \Carbon\Carbon::parse($timein->created_at)->timezone('Asia/Manila')->format('F d, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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

            const rfidInput = document.getElementById("rfid-scan");
            const userIdInput = document.getElementById("user-id-input");

            // Automatically focus on RFID input box when any key is pressed
            document.addEventListener("keydown", function (event) {
                if (event.key.length === 1) { // Only focus if a character or number key is pressed
                    rfidInput.focus();
                }
            });

            rfidInput.addEventListener("input", function () {
                if (rfidInput.value.length >= 10) {
                    document.getElementById("rfid-form").submit();
                }
            });

            // Auto-dismiss alerts after 3 seconds
            setTimeout(() => {
                const alert = document.querySelector('.alert');
                if (alert) {
                    alert.classList.remove('show');
                }
            }, 3000);
        });
    </script>

@endsection