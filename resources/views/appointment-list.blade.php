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

        /* Minimalist Header */
        .page-header {
            text-align: center;
            margin-bottom: 48px;
            padding: 0;
        }

        .page-header h1 {
            font-size: 28px;
            font-weight: 400;
            color: #333;
            margin: 0 0 8px 0;
        }

        .page-header p {
            font-size: 16px;
            color: #666;
            margin: 0;
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

        .filter-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding: 16px;
            background: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #e1e5e9;
        }

        .filter-links {
            display: flex;
            gap: 16px;
        }

        .filter-links a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .filter-links a:hover {
            background: #e3f2fd;
        }

        .filter-links a.active {
            background: #007bff;
            color: white;
        }

        .table-container {
            overflow-x: auto;
            border: 1px solid #e1e5e9;
            border-radius: 4px;
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
            min-width: 100px;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            text-align: center !important;
            min-width: 100px;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        /* Minimalist Checkbox */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #007bff;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        /* Minimalist Pagination */
        .pagination {
            margin-top: 24px;
            justify-content: center;
        }

        .page-link {
            border: 1px solid #e1e5e9;
            color: #007bff;
            padding: 8px 12px;
            margin: 0 2px;
            border-radius: 4px;
            font-size: 14px;
        }

        .page-link:hover {
            background: #f8f9fa;
            border-color: #007bff;
        }

        .page-item.active .page-link {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            background: #f8f9fa;
            border-color: #e1e5e9;
        }

        /* Minimalist Alert */
        .custom-alert-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
            font-size: 14px;
            margin-left: 16px;
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

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #666;
        }

        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 16px;
        }

        .empty-state h5 {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-wrapper {
                padding: 20px 16px;
            }

            .content-card {
                padding: 24px 16px;
            }

            .filter-options {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .filter-links {
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
            }
        }

        /* Fade animations */
        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Text utilities */
        .text-muted {
            color: #6c757d !important;
        }

        .text-success {
            color: #28a745 !important;
        }

        /* Dashboard-style button for View Proof */
        .btn-view-proof {
            background: linear-gradient(135deg, #e91e63, #c2185b);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(233, 30, 99, 0.3);
        }

        .btn-view-proof:hover {
            background: linear-gradient(135deg, #c2185b, #ad1457);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(233, 30, 99, 0.4);
        }

        .btn-view-proof i {
            font-size: 16px;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Appointments</h1>
                <p>Manage all appointment records and schedules</p>
            </div>

            <!-- Appointments Section -->
            <div class="content-card">
                <div class="table-section">
                    <h2>Appointment List</h2>

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

                    <!-- Filter Options Section -->
                    <div class="filter-options">
                        <div class="filter-links">
                            <!-- Link to view all appointments -->
                            <a href="#" id="select-all-link" class="active">All (0)</a>

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
                                    <button type="submit" class="btn btn-light border mx-2" id="moveToArchiveBtn" disabled>
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
                                    <th>
                                        <input type="checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Instructor</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Payment Method</th>
                                    <th>GCash Account Name</th>
                                    <th>GCash Account Number</th>
                                    <th>Proof of Payment</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through all appointments and display data -->
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <!-- Checkbox for each appointment -->
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $appointment->id }}"
                                                onchange="updateSelectionCount()" />
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $appointment->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $appointment->pendingMembership->name }}</strong>
                                        </td>
                                        <td>
                                            {{ $appointment->instructor->first_name . ' ' . $appointment->instructor->last_name }}
                                        </td>
                                        <td>{{ $appointment->selected_date }}</td>
                                        <td>{{ $appointment->selected_time }}</td>
                                        <td>{{ $appointment->payment_method }}</td>
                                        <td>{{ $appointment->gcash_account_name ?? 'N/A' }}</td>
                                        <td>{{ $appointment->gcash_account_number ?? 'N/A' }}</td>
                                        <td>
                                            @if($appointment->proof_of_payment)
                                                <a href="{{ Storage::url('app/public/' . $appointment->proof_of_payment) }}"
                                                    target="_blank" class="btn-view-proof">
                                                    <i class="fa fa-eye"></i>
                                                    View Proof
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <!-- Display Appointment Status -->
                                        <td>{{ $appointment->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="11">
                                            <div class="empty-state">
                                                <i class="fa fa-calendar"></i>
                                                <h5>No appointments found</h5>
                                                <p>There are no appointments to display</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if($appointments->hasPages())
                            <!-- Pagination Section -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <!-- Previous Page Link -->
                                    <li class="page-item {{ $appointments->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $appointments->previousPageUrl() }}">
                                            Previous
                                        </a>
                                    </li>

                                    <!-- Pagination Numbers -->
                                    @foreach(range(1, $appointments->lastPage()) as $page)
                                        <li class="page-item {{ $page == $appointments->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $appointments->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <!-- Next Page Link -->
                                    <li class="page-item {{ !$appointments->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $appointments->nextPageUrl() }}">
                                            Next
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
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
                const count = checkboxes.length;
                const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

                checkboxes.forEach(checkbox => {
                    selectedIds.push(checkbox.value); // Collect the checked checkbox values
                });
                document.getElementById('selectedIds').value = selectedIds.join(','); // Update hidden field with comma-separated IDs
                updateSelectAllLabel(count, totalCount); // Update the label with the correct count

                // Enable/disable move to archive button
                const moveToArchiveBtn = document.getElementById('moveToArchiveBtn');
                moveToArchiveBtn.disabled = count === 0;

                // Update select all checkbox
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = count === totalCount && totalCount > 0;
                selectAllCheckbox.indeterminate = count > 0 && count < totalCount;
            }

            // Update the "All" link label to show the number of selected items
            function updateSelectAllLabel(count, totalCount) {
                const selectAllLink = document.getElementById('select-all-link');
                selectAllLink.innerText = `All (${count}/${totalCount})`;
            }

            // Add functionality for the "All" link click
            document.getElementById('select-all-link').addEventListener('click', function (e) {
                e.preventDefault();
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
                toggleSelectAll(selectAllCheckbox);
            });

            // Initialize selection count on page load
            document.addEventListener("DOMContentLoaded", function () {
                updateSelectionCount(); // Set initial count based on pre-selected checkboxes
            });
        </script>

    </body>

    </html>
@endsection