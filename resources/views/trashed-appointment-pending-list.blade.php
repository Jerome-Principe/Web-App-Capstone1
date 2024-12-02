<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Trashed Appointments</title>
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

        .modal {
            z-index: 1055;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

<body>
    <div class="container">
        <div class="header-section">
            <h1>Trashed Appointments</h1>

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

        <!-- Filter options -->
        <div class="filter-options">
            <div class="filter-links">
                <a href="#" id="select-all-link">All (0)</a>
                <a href="{{ route('appointments.trashed') }}">Trashed
                    ({{App\Models\PendingAppointment::onlyTrashed()->count()}})
                </a>
            </div>

            <div>
                @csrf
                @method('DELETE')
                <div class="d-flex align-items-center">
                    <!-- Button to restore selected appointments -->
                    <form action="{{ route('appointments.restore.bulk') }}" method="POST" id="restore-selected-form">
                        @csrf
                        <input type="hidden" name="selected" id="selectedIds">
                        <button type="submit" class="btn btn-success mx-2">
                            <i class="fa fa-undo"></i> Restore Selected
                        </button>
                    </form>

                    <!-- Other actions (move to trash, search, etc.) -->
                    <form class="d-flex" role="search">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                            style="height: 35px;">
                        <button class="btn btn-primary ms-2" type="submit" style="height: 35px;">Search</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table -->
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
                    @foreach($trashedAppointments as $appointment)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $appointment->id }} "
                                    onchange="updateSelectionCount()">
                            </td>
                            <td class="text-center">
                                {{ ($trashedAppointments->currentPage() - 1) * $trashedAppointments->perPage() + $loop->index + 1 }}
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
                                    <form action="{{ route('appointments.restore', $appointment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                    </form>
                                    <form action="{{ route('appointments.forceDelete', $appointment->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure?')">Delete Permanently</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Controls -->
        {{ $trashedAppointments->links() }}
    </div>
</body>

<script>
    // Toggle select all checkboxes
    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('input[name="selected[]"]');
        checkboxes.forEach(item => item.checked = checkbox.checked);
        updateSelectionCount();
    }

    // Update selected count and hidden input value
    function updateSelectionCount() {
        const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
        const count = selectedCheckboxes.length;
        document.getElementById('select-all-link').textContent = `All (${count})`;
        const selectedIds = Array.from(selectedCheckboxes).map(input => input.value);
        document.getElementById('selectedIds').value = selectedIds.join(',');
        console.log(selectedIds.join(',')); // Log selected IDs to debug
    }

    // Add functionality for the "All (0)" link click
    document.getElementById('select-all-link').addEventListener('click', function (e) {
        e.preventDefault();
        const isChecked = this.textContent.includes('0') || this.textContent.includes('All (0)');
        const selectAllCheckbox = document.querySelector('input[type="checkbox"]');
        selectAllCheckbox.checked = isChecked;
        toggleSelectAll(selectAllCheckbox);
    });

    // Ensure the form doesn't submit if no appointments are selected
    document.getElementById('restore-selected-form').addEventListener('submit', function (e) {
        const selectedIds = document.getElementById('selectedIds').value;
        if (!selectedIds) {
            alert('Please select at least one appointments to restore.');
            e.preventDefault(); // Prevent form submission
        }
    });
</script>

@endsection