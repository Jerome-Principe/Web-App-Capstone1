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
            font-size: 14px;
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
            padding: 60px 24px;
            color: #666;
            width: 100%;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .empty-state i {
            font-size: 64px;
            color: #ddd;
            margin-bottom: 24px;
            display: block;
        }

        .empty-state h5 {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 12px;
            color: #333;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
            color: #888;
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
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Pending Appointments</h1>
                <p>Review and manage pending appointment requests</p>
            </div>

            <!-- Pending Appointments Section -->
            <div class="content-card">
                <div class="table-section">
                    <h2>Pending Appointment List</h2>

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
                            <a href="#" id="select-all-link" class="active">All (0)</a>
                            <a href="{{ route('appointments.pending.trashed') }}">Archived
                                ({{ App\Models\PendingAppointment::onlyTrashed()->count() }})
                            </a>
                        </div>

                        <div class="d-flex align-items-center">
                            <form action="{{ route('appointments.moveToTrash') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="selected" id="selectedIds">
                                <button type="submit" class="btn btn-light border mx-2" id="moveToArchiveBtn" disabled>
                                    <i class="fa fa-trash"></i> Move to Archive
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
                                    <th>
                                        <input type="checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Instructor</th>
                                    <th>Instructor Fees</th>
                                    <th>Gym Share</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Payment Method</th>
                                    <th>GCash Account Name</th>
                                    <th>GCash Account Number</th>
                                    <th>Proof of Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $appointment->id }}"
                                                onchange="updateSelectionCount()" />
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $appointment->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $appointment->pendingMembership->name ?? 'N/A' }}</strong>
                                        </td>
                                        <td>
                                            {{ $appointment->instructor->first_name . ' ' . $appointment->instructor->last_name }}
                                        </td>
                                        <td>₱{{ number_format($appointment->instructor_rate ?? 0, 2) }}</td>
                                        <td>₱{{ number_format($appointment->gym_rate ?? 0, 2) }}</td>
                                        <td>₱{{ number_format($appointment->total_amount ?? 0, 2) }}</td>
                                        <td>{{ $appointment->selected_date }}</td>
                                        <td>{{ $appointment->selected_time }}</td>
                                        <td>{{ $appointment->payment_method }}</td>
                                        <td>{{ $appointment->gcash_account_name ?? 'N/A' }}</td>
                                        <td>{{ $appointment->gcash_account_number ?? 'N/A' }}</td>
                                        <td>
                                            @if(strtolower($appointment->payment_method) === 'cash')
                                                <span class="text-muted">N/A</span>
                                            @elseif($appointment->proof_of_payment)
                                                <a href="{{ Storage::url('app/public/' . $appointment->proof_of_payment) }}"
                                                    target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-eye"></i> View Proof
                                                </a>
                                            @else
                                                <span class="text-muted">No proof uploaded</span>
                                            @endif
                                        </td>
                                        <td>{{ $appointment->status }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <form method="POST"
                                                    action="{{ route('appointments.approve', $appointment->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success btn-sm me-2">
                                                        <i class="fa fa-check mr-1"></i>Approve
                                                    </button>
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('appointments.decline', $appointment->id) }}"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-times mr-1"></i>Decline
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="15">
                                            <div class="empty-state">
                                                <i class="fa fa-clock"></i>
                                                <h5>No pending appointments found</h5>
                                                <p>There are no pending appointments to review</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if($appointments->hasPages())
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $appointments->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $appointments->previousPageUrl() }}">
                                            Previous
                                        </a>
                                    </li>

                                    @foreach(range(1, $appointments->lastPage()) as $page)
                                        <li class="page-item {{ $page == $appointments->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $appointments->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

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
            function toggleSelectAll(checkbox) {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]');
                checkboxes.forEach(item => item.checked = checkbox.checked);
                updateSelectionCount();
            }

            function updateSelectionCount() {
                const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
                const count = selectedCheckboxes.length;
                const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

                document.getElementById('select-all-link').textContent = `All (${count}/${totalCount})`;

                // Enable/disable move to archive button
                const moveToArchiveBtn = document.getElementById('moveToArchiveBtn');
                moveToArchiveBtn.disabled = count === 0;

                // Update select all checkbox
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = count === totalCount && totalCount > 0;
                selectAllCheckbox.indeterminate = count > 0 && count < totalCount;
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
                updateSelectionCount();
            });
        </script>
    </body>

@endsection

</html>