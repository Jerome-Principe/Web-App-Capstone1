<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Membership List</title>
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

        .badge.bg-info {
            background: #17a2b8 !important;
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

        /* Total Income Display */
        .total-income {
            background: #e8f5e8;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            padding: 16px;
            margin-top: 24px;
            text-align: center;
        }

        .total-income h5 {
            color: #155724;
            margin: 0;
            font-weight: 500;
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
                <h1>Memberships</h1>
                <p>Manage all active membership records and transactions</p>
            </div>

            <!-- Memberships Section -->
            <div class="content-card">
                <div class="table-section">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 1px solid #e1e5e9;">
                        <h2 style="margin: 0; font-size: 20px; font-weight: 500; color: #333;">Membership List</h2>
                        <button type="button" id="notifyAllBtn" class="btn btn-success" disabled
                            style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; padding: 10px 20px; font-size: 14px; font-weight: 500; border-radius: 8px; box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3); transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; opacity: 0.6;"
                            onmouseover="if(!this.disabled) { this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(40, 167, 69, 0.4)'; }"
                            onmouseout="if(!this.disabled) { this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(40, 167, 69, 0.3)'; }"
                            onclick="sendNotifications()">
                            <i class="fas fa-bell" style="font-size: 13px;"></i>
                            <span id="notifyBtnText">Notify All</span>
                            <span id="notifyBtnCount"
                                style="display: none; background: rgba(255,255,255,0.3); padding: 2px 6px; border-radius: 10px; font-size: 12px; margin-left: 4px;"></span>
                        </button>
                    </div>

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
                            <a href="#" id="select-all-link" class="active">All (0)</a>
                            <a href="{{ route('membership-pendings.trashed') }}">Archived
                                ({{App\Models\PendingMembership::onlyTrashed()->count()}})
                            </a>
                        </div>

                        <div>
                            @csrf
                            @method('DELETE')
                            <div class="d-flex align-items-center">
                                <!-- Form to move selected membership list to trash -->
                                <form action="{{ route('membership-pendings.moveToTrash') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="selected" id="selectedIds">
                                    <button type="submit" class="btn btn-light border mx-2" id="moveToArchiveBtn" disabled>
                                        <i class="fa fa-trash"></i> Move to Archive
                                    </button>
                                </form>

                                <!-- Date Filter Form -->
                                <form id="date-filter-form" method="GET"
                                    action="{{ route('membership.list.filterByDate') }}" class="d-flex align-items-center">
                                    <label for="date" class="form-label me-2">Select Date:</label>
                                    <input type="date" name="date" id="date" class="form-control me-2" style="width: 200px;"
                                        required>
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                </form>

                                <!-- Export PDF by Date -->
                                <form method="GET" action="{{ route('membership.list.exportPdfByDate') }}">
                                    <input type="hidden" name="date" id="pdf-date" value="{{ request('date') }}">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-file-pdf"></i> Export PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Memberships Table Section -->
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th>ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Start Date</th>
                                    <th>Expiry Date</th>
                                    <th>Membership Type</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($memberships as $membership)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $membership->id }}"
                                                onchange="updateSelectionCount()" />
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $membership->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $membership->first_name }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $membership->last_name }}</strong>
                                        </td>
                                        <td>{{ $membership->email }}</td>
                                        <td>
                                            @if($membership->start_date)
                                                <span class="badge bg-info">
                                                    {{ \Carbon\Carbon::parse($membership->start_date)->format('M d, Y') }}
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($membership->expiry_date)
                                                @php
                                                    $expiryDate = \Carbon\Carbon::parse($membership->expiry_date);
                                                    $daysRemaining = $expiryDate->diffInDays(\Carbon\Carbon::now());
                                                    $isExpiringSoon = $daysRemaining <= 30;
                                                @endphp
                                                <span class="badge {{ $isExpiringSoon ? 'bg-danger' : 'bg-warning' }}"
                                                    data-expiring="{{ $isExpiringSoon ? 'true' : 'false' }}">
                                                    {{ $expiryDate->format('M d, Y') }}
                                                    @if($isExpiringSoon)
                                                        <small style="display: block; font-size: 10px; margin-top: 2px;">
                                                            {{ $daysRemaining }} days left
                                                        </small>
                                                    @endif
                                                </span>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ ucfirst(optional($membership->requestMembership)->membership_type ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($membership->status === 'Active')
                                                <span class="badge bg-success">{{ $membership->status }}</span>
                                            @elseif($membership->status === 'Expired')
                                                <span class="badge bg-danger">{{ $membership->status }}</span>
                                            @elseif($membership->status === 'Pending')
                                                <span class="badge bg-warning">{{ $membership->status }}</span>
                                            @else
                                                <span class="badge">{{ $membership->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">
                                            <div class="empty-state">
                                                <i class="fa fa-users"></i>
                                                <h5>No memberships found</h5>
                                                <p>There are no membership records to display</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <!-- Total Income Display -->
                        @if(isset($totalIncome))
                            <div class="total-income">
                                <h5><i class="fa fa-money-bill-wave"></i> Total Income: ₱{{ number_format($totalIncome, 2) }}
                                </h5>
                            </div>
                        @endif

                        @if($memberships->hasPages())
                            <!-- Pagination Section -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $memberships->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $memberships->previousPageUrl() }}">
                                            Previous
                                        </a>
                                    </li>

                                    @foreach(range(1, $memberships->lastPage()) as $page)
                                        <li class="page-item {{ $page == $memberships->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $memberships->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <li class="page-item {{ !$memberships->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $memberships->nextPageUrl() }}">
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
                    checkbox.checked = source.checked;
                });
                updateSelectionCount();
            }

            // Function to update the selection count
            function updateSelectionCount() {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
                const selectedIds = [];
                const count = checkboxes.length;
                const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

                checkboxes.forEach(checkbox => {
                    selectedIds.push(checkbox.value);
                });
                document.getElementById('selectedIds').value = selectedIds.join(',');
                updateSelectAllLabel(count, totalCount);

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

            // Date filter form submission
            document.getElementById('date').addEventListener('change', function () {
                document.getElementById('date-filter-form').submit();
            });

            // Update PDF date field when date changes
            document.getElementById('date').addEventListener('change', function () {
                const pdfDateField = document.getElementById('pdf-date');
                pdfDateField.value = this.value;
            });

            // Notify All Button Functionality
            function checkExpiringMemberships() {
                const expiringBadges = document.querySelectorAll('span[data-expiring="true"]');
                const notifyBtn = document.getElementById('notifyAllBtn');
                const notifyBtnText = document.getElementById('notifyBtnText');
                const notifyBtnCount = document.getElementById('notifyBtnCount');

                const expiringCount = expiringBadges.length;
                const lastNotified = localStorage.getItem('lastNotificationSent');
                const now = new Date().getTime();
                const cooldownPeriod = 24 * 60 * 60 * 1000; // 24 hours in milliseconds

                // Check if cooldown period has passed
                const canSendNotification = !lastNotified || (now - parseInt(lastNotified)) > cooldownPeriod;

                if (expiringCount > 0 && canSendNotification) {
                    notifyBtn.disabled = false;
                    notifyBtn.style.opacity = '1';
                    notifyBtn.style.cursor = 'pointer';
                    notifyBtnCount.style.display = 'inline';
                    notifyBtnCount.textContent = expiringCount;
                    notifyBtnText.textContent = expiringCount === 1 ? 'Notify User' : 'Notify All';
                } else {
                    notifyBtn.disabled = true;
                    notifyBtn.style.opacity = '0.6';
                    notifyBtn.style.cursor = 'not-allowed';
                    notifyBtnCount.style.display = 'none';

                    if (expiringCount === 0) {
                        notifyBtnText.textContent = 'No Expiring Memberships';
                    } else if (!canSendNotification) {
                        const timeLeft = cooldownPeriod - (now - parseInt(lastNotified));
                        const hoursLeft = Math.ceil(timeLeft / (60 * 60 * 1000));
                        notifyBtnText.textContent = `Wait ${hoursLeft}h to notify again`;
                    }
                }
            }

            function sendNotifications() {
                const notifyBtn = document.getElementById('notifyAllBtn');
                if (notifyBtn.disabled) return;

                // Show loading state
                const originalText = document.getElementById('notifyBtnText').textContent;
                document.getElementById('notifyBtnText').textContent = 'Sending...';
                notifyBtn.disabled = true;
                notifyBtn.style.opacity = '0.6';

                // Collect expiring memberships data
                const expiringMemberships = [];
                const rows = document.querySelectorAll('tbody tr');
                console.log('🔍 Found rows:', rows.length);

                rows.forEach(row => {
                    const expiringBadge = row.querySelector('span[data-expiring="true"]');
                    console.log('🔍 Row check - expiringBadge:', expiringBadge);
                    if (expiringBadge) {
                        const cells = row.querySelectorAll('td');
                        console.log('🔍 Found cells:', cells.length);
                        if (cells.length >= 5) {
                            // Extract expiry date more reliably
                            const badgeText = expiringBadge.textContent.trim();
                            console.log('🔍 Badge text:', badgeText);

                            // Split by newline and get the first part (the date)
                            const lines = badgeText.split('\n');
                            const expiryDateText = lines[0].trim();
                            console.log('🔍 Extracted date:', expiryDateText);

                            const membershipData = {
                                id: cells[1].textContent.trim(),
                                firstName: cells[2].textContent.trim(),
                                lastName: cells[3].textContent.trim(),
                                email: cells[4].textContent.trim(),
                                expiryDate: expiryDateText,
                                daysLeft: badgeText.includes('days left') ?
                                    badgeText.match(/(\d+) days left/)?.[1] : null
                            };
                            console.log('📋 Adding membership:', membershipData);
                            expiringMemberships.push(membershipData);
                        }
                    }
                });

                console.log('📊 Total expiring memberships found:', expiringMemberships.length);
                console.log('📊 Memberships data:', expiringMemberships);

                // Send AJAX request to backend
                console.log('🚀 Sending request to backend...');
                console.log('🚀 Request body:', JSON.stringify({ memberships: expiringMemberships }));

                fetch('/api/send-expiry-notifications', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                            document.querySelector('input[name="_token"]')?.value
                    },
                    body: JSON.stringify({
                        memberships: expiringMemberships
                    })
                })
                    .then(response => {
                        console.log('📡 Response status:', response.status);
                        console.log('📡 Response headers:', response.headers);
                        return response.json();
                    })
                    .then(data => {
                        console.log('📡 Response data:', data);
                        if (data.success) {
                            // Store timestamp for cooldown
                            localStorage.setItem('lastNotificationSent', new Date().getTime().toString());

                            // Show success message
                            showNotificationAlert(`✅ Successfully sent notifications to ${data.count} member(s)`, 'success');

                            // Update button state
                            checkExpiringMemberships();
                        } else {
                            throw new Error(data.message || 'Failed to send notifications');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Detailed Error:', error);
                        console.error('❌ Error message:', error.message);
                        console.error('❌ Error stack:', error.stack);
                        showNotificationAlert('❌ Failed to send notifications. Please try again.', 'error');

                        // Reset button state
                        document.getElementById('notifyBtnText').textContent = originalText;
                        notifyBtn.disabled = false;
                        notifyBtn.style.opacity = '1';
                    });
            }

            function showNotificationAlert(message, type) {
                // Create alert element
                const alertDiv = document.createElement('div');
                alertDiv.className = 'custom-alert-message';
                alertDiv.style.backgroundColor = type === 'success' ? '#d4edda' : '#f8d7da';
                alertDiv.style.color = type === 'success' ? '#155724' : '#721c24';
                alertDiv.style.borderColor = type === 'success' ? '#c3e6cb' : '#f5c6cb';
                alertDiv.style.marginTop = '16px';
                alertDiv.textContent = message;

                // Insert after the header
                const headerDiv = document.querySelector('.table-section > div');
                headerDiv.insertAdjacentElement('afterend', alertDiv);

                // Remove after 5 seconds
                setTimeout(() => {
                    alertDiv.classList.add('fade-out');
                    setTimeout(() => alertDiv.remove(), 300);
                }, 5000);
            }

            // Initialize selection count on page load
            document.addEventListener("DOMContentLoaded", function () {
                updateSelectionCount();
                checkExpiringMemberships();

                // Check expiring memberships every 5 minutes
                setInterval(checkExpiringMemberships, 5 * 60 * 1000);
            });
        </script>

    </body>

@endsection