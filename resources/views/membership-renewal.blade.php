<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Membership Renewal</title>
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

        /* Filter and Export Section */
        .filter-export-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding: 16px;
            background: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #e1e5e9;
        }

        .date-filter {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .date-filter label {
            font-weight: 500;
            color: #333;
            margin: 0;
        }

        .date-filter input[type="date"] {
            padding: 8px 12px;
            border: 1px solid #e1e5e9;
            border-radius: 4px;
            font-size: 14px;
        }

        .export-buttons {
            display: flex;
            gap: 12px;
        }

        .btn-filter {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-filter:hover {
            background: #0056b3;
        }

        .btn-export {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-export:hover {
            background: #1e7e34;
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

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }

        .btn-approve {
            background: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-approve:hover {
            background: #1e7e34;
        }

        .btn-decline {
            background: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .btn-decline:hover {
            background: #c82333;
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

        .badge.bg-success {
            background: #28a745 !important;
            color: white;
        }

        .badge.bg-danger {
            background: #dc3545 !important;
            color: white;
        }

        .badge.bg-warning {
            background: #ffc107 !important;
            color: #212529;
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

            .filter-export-section {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .date-filter {
                justify-content: center;
            }

            .export-buttons {
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
            }
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
    <div class="main-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <h1>MEMBERSHIP RENEWAL</h1>
            <p>Review and manage membership renewal applications</p>
        </div>

        <!-- Membership Renewal Section -->
        <div class="content-card">
            <div class="table-section">
                <h2>Membership Renewal Applications</h2>

                <!-- Filter and Export Section -->
                <div class="filter-export-section">
                    <div class="date-filter">
                        <label for="date-filter">Select Date:</label>
                        <input type="date" id="date-filter" name="date-filter" placeholder="MM/DD/YYYY">
                        <button type="button" class="btn-filter" onclick="filterByDate()">
                            <i class="fa fa-filter"></i> Filter
                        </button>
                    </div>

                    <div class="export-buttons">
                        <button type="button" class="btn-export" onclick="exportToPDF()">
                            <i class="fa fa-file-pdf"></i> Export PDF
                        </button>
                        <button type="button" class="btn-fix" onclick="fixMembershipTypes()"
                            style="background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 4px; font-size: 14px; cursor: pointer; margin-left: 8px;">
                            <i class="fa fa-wrench"></i> Fix Types
                        </button>
                    </div>
                </div>

                <!-- Membership Renewal Table Section -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Membership Type</th>
                                <th>Payment Method</th>
                                <th>GCash #</th>
                                <th>Acc. Name</th>
                                <th>Ref. #</th>
                                <th>Proof of Payment</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($renewals ?? collect([]) as $renewal)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $renewal->id ?? 'N/A' }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $renewal->name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>{{ $renewal->membership_type ?? 'N/A' }}</td>
                                    <td>{{ $renewal->payment_method ?? 'N/A' }}</td>
                                    <td>{{ $renewal->gcash_number ?? 'N/A' }}</td>
                                    <td>{{ $renewal->account_name ?? 'N/A' }}</td>
                                    <td>{{ $renewal->reference_number ?? 'N/A' }}</td>
                                    <td>
                                        @if(isset($renewal->proof_of_payment_url) && $renewal->proof_of_payment_url)
                                            <a href="{{ url($renewal->proof_of_payment_url) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="fa fa-eye"></i> View Proof
                                            </a>
                                        @else
                                            <span class="text-muted">No proof uploaded</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($renewal->status === 'Pending')
                                            <div class="action-buttons">
                                                <form action="{{ route('membership-renewal.approve', $renewal->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-approve">
                                                        <i class="fa fa-check"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('membership-renewal.decline', $renewal->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-decline">
                                                        <i class="fa fa-times"></i> Decline
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="badge {{ $renewal->status === 'Approved' ? 'bg-success' : 'bg-danger' }}">
                                                {{ $renewal->status }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
                                        <div class="empty-state">
                                            <i class="fa fa-users"></i>
                                            <h5>No renewal applications found</h5>
                                            <p>There are no membership renewal applications to display</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to filter by date
        function filterByDate() {
            const dateFilter = document.getElementById('date-filter');
            const selectedDate = dateFilter.value;

            if (selectedDate) {
                // You can implement the actual filtering logic here
                console.log('Filtering by date:', selectedDate);
                // Redirect to the same page with date parameter
                window.location.href = window.location.pathname + '?date=' + selectedDate;
            } else {
                alert('Please select a date to filter');
            }
        }

        // Function to export to PDF
        function exportToPDF() {
            const dateFilter = document.getElementById('date-filter');
            const selectedDate = dateFilter.value;

            // You can implement the actual PDF export logic here
            console.log('Exporting to PDF with date:', selectedDate);

            // Example: redirect to PDF export route
            let exportUrl = '{{ route("membership-renewal.export-pdf") }}';
            if (selectedDate) {
                exportUrl += '?date=' + selectedDate;
            }
            window.open(exportUrl, '_blank');
        }

        // Function to fix membership types
        function fixMembershipTypes() {
            if (confirm('This will update membership types for all approved renewals. Are you sure you want to continue?')) {
                // Create a form and submit it
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("membership-renewal.fix-types") }}';

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Initialize date filter with current date if no date is selected
        document.addEventListener("DOMContentLoaded", function () {
            const dateFilter = document.getElementById('date-filter');
            if (!dateFilter.value) {
                const today = new Date().toISOString().split('T')[0];
                dateFilter.value = today;
            }
        });
    </script>
@endsection