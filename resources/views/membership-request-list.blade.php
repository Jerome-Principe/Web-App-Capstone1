<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{asset('assets/images/muscle.png')}}" type="image/png">
    <title>Request For Membership</title>
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
            max-height: 700px;
            overflow-y: auto;
            overflow-x: auto;
            white-space: nowrap;
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
            position: sticky;
            top: 0;
            z-index: 10;
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
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Membership Requests</h1>
                <p>View and manage all membership applications</p>
            </div>

            <!-- Membership Requests Section -->
            <div class="content-card">
                <div class="table-section">
                    <div class="mb-4">
                        <h1 class="card-title mb-0" style="font-size: 20px; font-weight: 500; color: #333;">Request For
                            Membership</h1>
                        <p class="text-muted mb-0">View and manage all membership applications</p>
                    </div>

                    <!-- Filter Options Section -->
                    <div class="filter-options">
                        <div class="filter-links">
                            <a href="#" id="select-all-link" class="active">All (0)</a>
                        </div>

                        <div>
                            <!-- Search Form -->
                            <form class="d-flex" role="search" method="GET" action="{{ url('/membership-request-list') }}">
                                <input class="form-control" type="search" name="search"
                                    placeholder="Search membership requests..." aria-label="Search"
                                    value="{{ request('search') }}" style="height: 35px;" id="searchInput">
                                <button class="btn btn-primary ms-2" type="submit" style="height: 35px;">Search</button>
                            </form>
                        </div>
                    </div>

                    <!-- Membership Requests Table Section -->
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th>ID</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Date Of Birth</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Weight</th>
                                    <th>Height</th>
                                    <th>Address</th>
                                    <th>Postal Code</th>
                                    <th>Email</th>
                                    <th>Work</th>
                                    <th>Mobile Number</th>
                                    <th>Gym Source</th>
                                    <th>Membership Type</th>
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
                                            <strong>{{ $membership->last_name }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $membership->first_name }}</strong>
                                        </td>
                                        <td>{{ $membership->middle_name ?? 'N/A' }}</td>
                                        <td>{{ $membership->date ? \Carbon\Carbon::parse($membership->date)->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge">{{ $membership->gender ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ $membership->age ?? 'N/A' }}</td>
                                        <td>{{ $membership->weight ?? 'N/A' }}</td>
                                        <td>{{ $membership->height ?? 'N/A' }}</td>
                                        <td>{{ $membership->address ?? 'N/A' }}</td>
                                        <td>{{ $membership->postal_code ?? 'N/A' }}</td>
                                        <td>{{ $membership->email }}</td>
                                        <td>{{ $membership->work ?? 'N/A' }}</td>
                                        <td>{{ $membership->mobile ?? 'N/A' }}</td>
                                        <td>{{ $membership->gym_source ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-success">{{ $membership->membership_type ?? 'N/A' }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="17">
                                            <div class="empty-state">
                                                <i class="fa fa-file-alt"></i>
                                                <h5>No membership requests found</h5>
                                                <p>There are no membership applications to display</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center mt-4 mb-4">
                                <li class="page-item {{ $memberships->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $memberships->previousPageUrl() }}"
                                        tabindex="-1">Previous</a>
                                </li>

                                @foreach(range(1, $memberships->lastPage()) as $page)
                                    <li class="page-item {{ $page == $memberships->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $memberships->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ !$memberships->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $memberships->nextPageUrl() }}">Next</a>
                                </li>
                            </ul>
                        </nav>
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
                const count = checkboxes.length;
                const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

                updateSelectAllLabel(count, totalCount);

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
                updateSelectionCount();
            });
        </script>

        <script>
            // Live search functionality for membership requests
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchInput');
                const tableContainer = document.querySelector('.table-container');
                const paginationContainer = document.querySelector('.pagination');
                let searchTimeout;

                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        clearTimeout(searchTimeout);

                        // Debounce search to avoid too many requests
                        searchTimeout = setTimeout(() => {
                            performLiveSearch(this.value);
                        }, 300);
                    });
                }

                function performLiveSearch(searchTerm) {
                    // Show loading state
                    if (tableContainer) {
                        tableContainer.style.opacity = '0.6';
                    }

                    const url = new URL(window.location.href);
                    url.searchParams.set('search', searchTerm);

                    fetch(url.toString(), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html, application/xhtml+xml'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            // Create a temporary div to parse the HTML
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = html;

                            // Extract and update the table content
                            const newTableContainer = tempDiv.querySelector('.table-container');
                            if (newTableContainer && tableContainer) {
                                tableContainer.innerHTML = newTableContainer.innerHTML;
                            }

                            // Extract and update pagination
                            const newPagination = tempDiv.querySelector('.pagination');
                            if (newPagination && paginationContainer) {
                                paginationContainer.innerHTML = newPagination.innerHTML;
                            }

                            // Reset opacity
                            if (tableContainer) {
                                tableContainer.style.opacity = '1';
                            }

                            // Update URL without page reload
                            history.pushState(null, '', url.toString());
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            if (tableContainer) {
                                tableContainer.style.opacity = '1';
                            }
                        });
                }

                // Handle pagination clicks for search results
                document.addEventListener('click', function (e) {
                    if (e.target.closest('.pagination a')) {
                        e.preventDefault();
                        const link = e.target.closest('.pagination a');
                        const href = link.getAttribute('href');

                        if (href) {
                            fetch(href, {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'text/html, application/xhtml+xml'
                                }
                            })
                                .then(response => response.text())
                                .then(html => {
                                    const tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = html;

                                    const newTableContainer = tempDiv.querySelector('.table-container');
                                    if (newTableContainer && tableContainer) {
                                        tableContainer.innerHTML = newTableContainer.innerHTML;
                                    }

                                    const newPagination = tempDiv.querySelector('.pagination');
                                    if (newPagination && paginationContainer) {
                                        paginationContainer.innerHTML = newPagination.innerHTML;
                                    }

                                    // Update URL
                                    history.pushState(null, '', href);
                                })
                                .catch(error => {
                                    console.error('Pagination error:', error);
                                });
                        }
                    }
                });
            });
        </script>

    </body>
@endsection