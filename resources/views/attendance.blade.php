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
            text-align: center;
            border-bottom: 1px solid #e1e5e9;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            text-align: center;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        /* Minimalist Button Styles */
        .btn {
            border-radius: 4px;
            padding: 10px 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background: #0056b3;
            border-color: #0056b3;
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

        /* Minimalist Alert */
        .alert {
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 14px;
            margin-bottom: 15px;
            min-width: 200px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

</head>

@extends('layouts.master')

@section('content')

    <div class="main-wrapper">
        <!-- Clock Section -->
        <div class="content-card">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
            <div id="date" class="date-display">00/00/00</div>
            <p class="instruction-text">Place your RFID card on the reader or enter your user ID to record your time in and time out</p>
        </div>

        <!-- Input Box -->
        <div class="content-card">
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
        </div>

        <!-- Table Section -->
        <div class="content-card">
            <div class="table-section">
                <h2>Recent Time Ins</h2>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Username</th>
                                <th>RFID Number</th>
                                <th style="width: 100px;">Time In</th>
                                <th style="width: 120px;">Date Logged</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timeIns as $timein)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $timein->id }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $timein->username }}</strong>
                                    </td>
                                    <td>{{ $timein->rfid }}</td>
                                    <td>{{ \Carbon\Carbon::parse($timein->time_in)->timezone('Asia/Manila')->format('h:i A') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($timein->created_at)->timezone('Asia/Manila')->format('F d, Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection