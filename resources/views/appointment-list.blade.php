<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Appointment List</title>
    <style>
        /* General page styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        /* Container styling */
        .container {
            max-width: 1000px;
            margin: 30px auto;
            background-color: #f8f9fc;
            /* Light background */
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
        }

        /* Header section styling */
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

        /* Filter options layout */
        .filter-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            align-items: center;
        }

        /* Links for filter options */
        .filter-links {
            display: flex;
        }

        .filter-options a {
            margin-right: 15px;
            color: #007bff;
            text-decoration: none;
        }

        /* Table container with horizontal scroll */
        .table-container {
            overflow-x: auto;
            white-space: nowrap;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: transparent;
        }

        th {
            font-weight: bold;
            border-bottom: 1px solid #999;
            padding: 12px 10px;
            text-align: center;
            background-color: transparent !important;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
        }

        /* Hover effect */
        tbody tr:hover {
            background-color: #eaeaea;
            cursor: pointer;
        }

        /* Checkbox styling */
        input[type="checkbox"] {
            margin: 0;
        }

        /* Date information font styling */
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
                <h1>Appointment List</h1>

                <!-- Success message if exists -->
                @if(session('success'))
                    <div class="custom-alert-message">
                        {{ session('success') }}
                    </div>
                @endif

                <script>
                    // Hide success message after 3 seconds
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

            <!-- Filter Options Section -->
            <div class="filter-options">
                <div class="filter-links">
                    <!-- Link to view all appointments -->
                    <a href="#" id="select-all-link">All (0)</a>

                    <!-- Link to view trashed appointments -->
                    <a href="{{ route('appointments.pending.trashed') }}">Archived
                        ({{ App\Models\PendingAppointment::onlyTrashed()->count() }})
                    </a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Form to move selected appointments to trash -->
                        <form action="{{ route('appointments.moveToTrash') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2">
                                <i class="fa fa-trash"></i> Move to Archive
                            </button>
                        </form>

                        <!-- Search Form -->
                        <form class="d-flex" role="search" action="#" method="GET">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                style="height: 35px;">
                            <button class="btn btn-primary ms-2" type="submit" style="height: 35px;">Search</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Appointments Table Section -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <!-- Checkbox to select all appointments -->
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
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through all appointments and display data -->
                        @foreach($appointments as $appointment)
                            <tr>
                                <!-- Checkbox for each appointment -->
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $appointment->id }} "
                                        onchange="updateSelectionCount()" /></td>
                                <td class="text-center">{{ $appointment->id }}</td>
                                <td class="text-center">{{ $appointment->pendingMembership->name }}</td>
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
                                <!-- Display Appointment Status -->
                                <td class="text-center">{{ $appointment->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Section -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4 mb-4">
                        <!-- Previous Page Link -->
                        <li class="page-item {{ $appointments->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $appointments->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        <!-- Pagination Numbers -->
                        @foreach(range(1, $appointments->lastPage()) as $page)
                            <li class="page-item {{ $page == $appointments->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $appointments->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <!-- Next Page Link -->
                        <li class="page-item {{ !$appointments->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $appointments->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <script>
            // Function to toggle select all checkboxes
            function toggleSelectAll(source) {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked; // Select or deselect based on the source checkbox
                });
                updateSelectionCount(); // Update the count
            }

            // Function to update the selection count
            function updateSelectionCount() {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
                const selectedIds = [];
                checkboxes.forEach(checkbox => {
                    selectedIds.push(checkbox.value); // Collect the checked checkbox values
                });
                document.getElementById('selectedIds').value = selectedIds.join(','); // Update hidden field with comma-separated IDs
                updateSelectAllLabel(selectedIds.length); // Update the label with the correct count
            }

            // Update the "All" link label to show the number of selected items
            function updateSelectAllLabel(count) {
                const selectAllLink = document.getElementById('select-all-link');
                selectAllLink.innerText = `All (${count})`;
            }

            // Initialize selection count on page load
            document.addEventListener("DOMContentLoaded", function () {
                updateSelectionCount(); // Set initial count based on pre-selected checkboxes
            });
        </script>


    </body>

    </html>
@endsection