<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Pending Appointment List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: #f8f9fc;
            /* soft light gray background */
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-section h1 {
            font-size: 24px;
            margin-right: 10px;
        }

        .filter-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            align-items: center;
        }

        .filter-links {
            display: flex;
        }

        .filter-options a {
            margin-right: 15px;
            color: #007bff;
            text-decoration: none;
        }

        .table-container {
            overflow-x: auto;
            white-space: nowrap;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: transparent;
            font-size: 14px;
        }

        th {
            font-weight: bold;
            background-color: transparent !important;
            border-bottom: 1px solid #999;
            padding: 12px 10px;
            text-align: center;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
        }

        tr:last-child td {
            border-bottom: none;
        }

        input[type="checkbox"] {
            margin: 0;
        }

        .date-info {
            font-size: 12px;
            color: gray;
        }

        .custom-alert-message {
            margin: 10px 0;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            transition: opacity 0.5s ease;
        }

        .custom-alert-message.fade-out {
            opacity: 0;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Pending Appointment List</h1>
            </div>

            @if(session('success'))
                <div class="custom-alert-message">
                    {{ session('success') }}
                </div>
            @endif

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    setTimeout(function () {
                        const alert = document.querySelector('.custom-alert-message');
                        if (alert) {
                            alert.classList.add('fade-out');
                        }
                    }, 3000);
                });
            </script>

            <div class="filter-options">
                <div class="filter-links">
                    <a href="#" id="select-all-link">All (0)</a>
                    <a href="{{ route('appointments.pending.trashed') }}">Trashed
                        ({{ App\Models\PendingAppointment::onlyTrashed()->count() }})</a>
                </div>

                <div class="d-flex align-items-center">
                    <form action="{{ route('appointments.moveToTrash') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="selected" id="selectedIds">
                        <button type="submit" class="btn btn-light border mx-2">
                            <i class="fa fa-trash"></i> Move to Trash
                        </button>
                    </form>

                    <form class="d-flex" role="search">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                            style="height: 35px;">
                        <button class="btn btn-primary ms-2" type="submit" style="height: 35px;">Search</button>
                    </form>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                            <th class="text-center">ID</th>
                            <th class="text-center">User</th>
                            <th class="text-center">Instructor</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Time</th>
                            <th class="text-center">Payment Method</th>
                            <th class="text-center">GCash Account Name</th>
                            <th class="text-center">GCash Account Number</th>
                            <th class="text-center">Proof of Payment</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $appointment->id }}"
                                        onchange="updateSelectionCount()" /></td>
                                <td class="text-center">{{ $appointment->id }}</td>
                                <td class="text-center">{{ $appointment->pendingMembership->name ?? 'N/A' }}</td>
                                <td class="text-center">
                                    {{ $appointment->instructor->first_name . ' ' . $appointment->instructor->last_name }}
                                </td>
                                <td class="text-center">{{ $appointment->selected_date }}</td>
                                <td class="text-center">{{ $appointment->selected_time }}</td>
                                <td class="text-center">{{ $appointment->payment_method }}</td>
                                <td class="text-center">{{ $appointment->gcash_account_name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $appointment->gcash_account_number ?? 'N/A' }}</td>
                                <td class="text-center">
                                    @if($appointment->proof_of_payment)
                                        <a href="{{ Storage::url('app/public/' . $appointment->proof_of_payment) }}"
                                            target="_blank">View</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="text-center">{{ $appointment->status }}</td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('appointments.approve', $appointment->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('appointments.decline', $appointment->id) }}"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-danger">Decline</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4 mb-4">
                        <li class="page-item {{ $appointments->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $appointments->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $appointments->lastPage()) as $page)
                            <li class="page-item {{ $page == $appointments->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $appointments->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$appointments->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $appointments->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>

        <script>
            function toggleSelectAll(checkbox) {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]');
                checkboxes.forEach(item => item.checked = checkbox.checked);
                updateSelectionCount();
            }

            function updateSelectionCount() {
                const selected = document.querySelectorAll('input[name="selected[]"]:checked').length;
                document.getElementById('select-all-link').textContent = `All (${selected})`;
            }
        </script>
    </body>

@endsection

</html>