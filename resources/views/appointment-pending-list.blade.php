<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
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
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header-section {
            display: flex;
            justify-content: flex-start;
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
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        table th {
            background-color: #f0f0f0 !important;
        }

        input[type="checkbox"] {
            margin: 0;
        }

        .date-info {
            font-size: 12px;
            color: gray;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

<body>
    <div class="container">
        <div class="header-section">
            <h1>Pending Appointment List</h1>

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
        </div>

        <div class="filter-options">
            <div class="filter-links">
                <a href="#" id="select-all-link">All (0)</a>
                <a href="{{route('appointments.trashed')}}">Trashed
                    ({{App\Models\PendingAppointment::onlyTrashed()->count()}})
                </a>
            </div>

            <div>
                @csrf
                @method('DELETE')
                <div class="d-flex align-items-center">
                    <form action="{{ route('appointments.moveToTrash') }}" method="POST">
                        @csrf
                        <div class="d-flex align-items-center">
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
        </div>
    </div>

    <div class="table-container">
        <table class="table table-bordered text-center">
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
                                onchange="updateSelectionCount()" />
                        </td>
                        <td class="text-center">
                            {{ ($appointments->currentPage() - 1) * $appointments->perPage() + $loop->index + 1 }}
                        </td>
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
                                    target="_blank">View
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="text-center">{{ $appointment->status }}</td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Approve Form -->
                                <form method="POST" action="{{ route('appointments.approve', $appointment->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success">Approve</button>
                                </form>

                                <!-- Decline Form -->
                                <form method="POST" action="{{ route('appointments.decline', $appointment->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-danger">Decline</button>
                                </form>
                            </div>
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
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateSelectionCount();
        }

        function updateSelectionCount() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const count = checkboxes.length;
            document.getElementById('select-all-link').innerText = `All (${count})`;
        }

        const selectedIds = [];

        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = source.checked;
                if (source.checked) {
                    selectedIds.push(checkbox.value);
                } else {
                    selectedIds.length = 0;
                }
            });
            document.getElementById('selectedIds').value = selectedIds.join(',');
        }

        function updateSelectionCount() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const ids = Array.from(checkboxes).map((checkbox) => checkbox.value.trim());
            document.getElementById('selectedIds').value = ids.join(',');
        }
    </script>
</body>
@endsection