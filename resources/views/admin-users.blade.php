@extends('layouts.master')

@section('title', 'Admin User List')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <!-- Header Section -->
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="d-flex align-items-center gap-3 mb-2">
                                <h1 class="card-title mb-0">Admin User Information</h1>
                                <a href="/register" class="btn btn-primary d-inline-flex align-items-center">
                                    <i class="fa fa-plus mr-2"></i>
                                    Add New User
                                </a>
                            </div>
                            <p class="text-muted mb-0">Manage and monitor all user accounts in the system</p>
                        </div>

                        <!-- Success Message -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle mr-2"></i>
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <!-- Search and Filter Section -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fa fa-search"></i>
                                        </span>
                                    </div>
                                    <input type="search" id="liveSearch" name="search" class="form-control"
                                        placeholder="Type to search users by name, email, or ID... (min 2 characters)"
                                        aria-label="Search" value="{{ request('search') }}" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="searchStatus" style="display: none;">
                                            <i class="fa fa-search text-primary"></i>
                                        </span>
                                        <button class="btn btn-outline-secondary" type="button" id="searchBtn">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        @if(request('search'))
                                            <a href="{{ route('admin-users.index') }}" class="btn btn-outline-danger">
                                                <i class="fa fa-times"></i> Clear
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <!-- Loading indicator -->
                                <div id="searchLoading" class="mt-2" style="display: none;">
                                    <small class="text-muted">
                                        <i class="fa fa-spinner fa-spin"></i> Searching...
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <div class="d-flex flex-column align-items-md-end">
                                    <span class="text-muted">Selected: <span id="selection-count"
                                            class="font-weight-bold">0</span></span>
                                    <div id="searchResultsInfo">
                                        @if(request('search'))
                                            <small class="text-info">
                                                <i class="fa fa-search mr-1"></i>
                                                Search results for "{{ request('search') }}": {{ $users->total() }} user(s)
                                                found
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col" style="width: 50px; text-align: center;">
                                            <div class="custom-control custom-checkbox d-flex justify-content-center">
                                                <input type="checkbox" class="custom-control-input" id="selectAll"
                                                    onclick="toggleSelectAll(this)">
                                                <label class="custom-control-label" for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th scope="col" style="text-align: center;">ID</th>
                                        <th scope="col" style="text-align: center;">Username</th>
                                        <th scope="col" style="text-align: center;">Email</th>
                                        <th scope="col" style="text-align: center;">Created At</th>
                                        <th scope="col" style="text-align: center;">Updated At</th>
                                        <th scope="col" style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($users->count() > 0)
                                        @foreach ($users as $index => $user)
                                            <tr>
                                                <td style="text-align: center;">
                                                    <div class="custom-control custom-checkbox d-flex justify-content-center">
                                                        <input type="checkbox" class="custom-control-input" name="selected[]"
                                                            value="{{ $user->id }}" id="user{{ $user->id }}"
                                                            onchange="updateSelectionCount()">
                                                        <label class="custom-control-label" for="user{{ $user->id }}"></label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-secondary">#{{ $user->id }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm mr-3">
                                                            <div class="avatar-title rounded-circle bg-primary text-white">
                                                                {{ substr($user->name, 0, 2) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $user->email }}</span>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-calendar mr-2 text-muted"></i>
                                                        <small
                                                            class="text-muted">{{ $user->created_at->format('M d, Y | h:i A') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-clock-o mr-2 text-muted"></i>
                                                        <small
                                                            class="text-muted">{{ $user->updated_at->format('M d, Y | h:i A') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin-users.edit', $user->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="fa fa-pencil mr-1"></i>
                                                            Update
                                                        </a>
                                                        <form action="{{ route('admin-users.destroy', $user->id) }}" method="POST"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                onclick="return confirm('Are you sure you want to delete this user account?')"
                                                                class="btn btn-sm btn-outline-danger">
                                                                <i class="fa fa-trash mr-1"></i>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                @if(request('search'))
                                                    <div class="text-muted">
                                                        <i class="fa fa-search fa-2x mb-3"></i>
                                                        <h5>No users found</h5>
                                                        <p>No users match your search criteria "{{ request('search') }}"</p>
                                                        <a href="{{ route('admin-users.index') }}" class="btn btn-outline-primary">
                                                            <i class="fa fa-arrow-left mr-1"></i> View All Users
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="text-muted">
                                                        <i class="fa fa-users fa-2x mb-3"></i>
                                                        <h5>No users found</h5>
                                                        <p>There are no users in the system yet.</p>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of
                                {{ $users->total() }} results
                            </div>
                            @if($users->hasPages())
                                <nav aria-label="Page navigation">
                                    <ul class="pagination pagination-sm mb-0">
                                        @if($users->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a>
                                            </li>
                                        @endif

                                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            @if($page == $users->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach

                                        @if($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @else
                                <div class="text-muted">
                                    <small>All results shown on this page</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar-sm {
            width: 40px;
            height: 40px;
        }

        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .table td {
            vertical-align: middle !important;
            border-top: 1px solid #f8f9fa;
            text-align: center !important;
            padding: 12px 8px;
            display: table-cell;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            text-align: center !important;
            vertical-align: middle !important;
            padding: 12px 8px;
            display: table-cell;
        }

        /* Ensure all content inside cells is centered */
        .table td *,
        .table th * {
            text-align: center !important;
        }

        /* Center flex containers */
        .table td .d-flex,
        .table th .d-flex {
            justify-content: center !important;
            align-items: center !important;
        }

        /* Center button groups */
        .table td .btn-group {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }

        /* Perfect centering for checkboxes */
        .custom-control {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 0 !important;
            height: 100% !important;
            min-height: 20px !important;
            position: relative !important;
        }

        .custom-control-input {
            margin: 0 !important;
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
        }

        .custom-control-label {
            margin: 0 !important;
            position: relative !important;
            top: 0 !important;
            left: 0 !important;
        }

        /* Center checkboxes in table cells */
        .table th .custom-control,
        .table td .custom-control {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
            height: 100% !important;
            min-height: 40px !important;
            position: relative !important;
        }

        /* Ensure checkbox containers are perfectly centered */
        .custom-control.custom-checkbox {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            margin: 0 auto !important;
            height: 100% !important;
            position: relative !important;
        }

        /* Ensure table cells have proper vertical alignment */
        .table th,
        .table td {
            vertical-align: middle !important;
            text-align: center !important;
            padding: 12px 8px !important;
            height: auto !important;
            min-height: 50px !important;
            position: relative !important;
        }

        /* Specific centering for checkbox columns */
        .table th:first-child,
        .table td:first-child {
            vertical-align: middle !important;
            text-align: center !important;
            display: table-cell !important;
            position: relative !important;
        }

        /* Override any Bootstrap positioning that might affect centering */
        .custom-control-input:checked~.custom-control-label::before,
        .custom-control-label::before {
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
        }

        .custom-control-input:checked~.custom-control-label::after,
        .custom-control-label::after {
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .table {
            background: white;
        }

        .table th {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e1e5e9;
        }

        .btn-group .btn {
            margin-right: 5px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        .custom-control-input:checked~.custom-control-label::before {
            background-color: #007bff;
            border-color: #007bff;
        }

        .badge {
            font-size: 11px;
            padding: 0.375rem 0.75rem;
        }

        .alert {
            border: none;
            border-radius: 0.375rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            border: 1px solid #e1e5e9;
        }

        .card-title {
            color: #495057;
            font-weight: 600;
        }

        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .table-responsive {
            border: 1px solid #e1e5e9;
            border-radius: 4px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.2s ease;
        }

        /* Pagination styling */
        .pagination {
            margin: 0;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .pagination .page-link {
            border: 1px solid #dee2e6;
            color: #007bff;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #0056b3;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>

    <script>
        // Select all checkboxes
        function toggleSelectAll(source) {
            const checkboxes = document.getElementsByName('selected[]');
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
            updateSelectionCount();
        }

        // Update the selection count
        function updateSelectionCount() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const count = checkboxes.length;
            document.getElementById('selection-count').innerText = count;
        }

        // Auto-hide success message after 5 seconds
        document.addEventListener("DOMContentLoaded", function () {
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(function () {
                    const closeButton = successAlert.querySelector('.close');
                    if (closeButton) {
                        closeButton.click();
                    }
                }, 5000);
            }

            // Search functionality enhancements
            const searchInput = document.getElementById('liveSearch');
            const searchBtn = document.getElementById('searchBtn');
            const searchLoading = document.getElementById('searchLoading');
            const searchResultsInfo = document.getElementById('searchResultsInfo');
            const searchStatus = document.getElementById('searchStatus');

            let searchTimeout;

            if (searchInput) {
                // Live search as user types (with debouncing)
                searchInput.addEventListener('input', function () {
                    const searchTerm = this.value.trim();

                    // Clear previous timeout
                    clearTimeout(searchTimeout);

                    // Hide loading initially
                    searchLoading.style.display = 'none';
                    searchBtn.disabled = false;
                    searchBtn.innerHTML = '<i class="fa fa-search"></i> Search';

                    searchStatus.style.display = 'none'; // Hide status icon

                    // If search term is empty, show all users
                    if (searchTerm === '') {
                        window.location.href = '{{ route("admin-users.index") }}';
                        return;
                    }

                    // Only search if at least 2 characters (for better performance)
                    if (searchTerm.length < 2) {
                        return;
                    }

                    // Show loading after 200ms delay (debouncing) - faster response
                    searchTimeout = setTimeout(() => {
                        searchLoading.style.display = 'block';
                        searchStatus.style.display = 'inline-block'; // Show status icon
                        performLiveSearch(searchTerm);
                    }, 200);
                });

                // Manual search button
                searchBtn.addEventListener('click', function () {
                    const searchTerm = searchInput.value.trim();
                    if (searchTerm) {
                        searchLoading.style.display = 'block';
                        searchBtn.disabled = true;
                        searchBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Searching...';
                        searchStatus.style.display = 'inline-block'; // Show status icon
                        performLiveSearch(searchTerm);
                    }
                });

                // Auto-submit on Enter key
                searchInput.addEventListener('keypress', function (e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const searchTerm = this.value.trim();
                        if (searchTerm) {
                            searchLoading.style.display = 'block';
                            searchBtn.disabled = true;
                            searchBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Searching...';
                            searchStatus.style.display = 'inline-block'; // Show status icon
                            performLiveSearch(searchTerm);
                        }
                    }
                });

                // Function to perform live search
                function performLiveSearch(searchTerm) {
                    fetch(`{{ route('admin-users.index') }}?search=${encodeURIComponent(searchTerm)}`, {
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

                            // Extract the table body content
                            const newTableBody = tempDiv.querySelector('tbody');
                            const currentTableBody = document.querySelector('tbody');

                            if (newTableBody && currentTableBody) {
                                currentTableBody.innerHTML = newTableBody.innerHTML;
                            }

                            // Update search results info
                            const newSearchInfo = tempDiv.querySelector('#searchResultsInfo');
                            if (newSearchInfo && searchResultsInfo) {
                                searchResultsInfo.innerHTML = newSearchInfo.innerHTML;
                            }

                            // Update pagination if needed
                            const newPagination = tempDiv.querySelector('.pagination');
                            const currentPagination = document.querySelector('.pagination');
                            if (newPagination && currentPagination) {
                                currentPagination.innerHTML = newPagination.innerHTML;
                            }

                            // Hide loading
                            searchLoading.style.display = 'none';
                            searchBtn.disabled = false;
                            searchBtn.innerHTML = '<i class="fa fa-search"></i> Search';
                            searchStatus.style.display = 'none'; // Hide status icon

                            // Re-initialize checkbox functionality
                            updateSelectionCount();

                            // Highlight search terms
                            highlightSearchTerms(searchTerm);
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            searchLoading.style.display = 'none';
                            searchBtn.disabled = false;
                            searchBtn.innerHTML = '<i class="fa fa-search"></i> Search';
                            searchStatus.style.display = 'none'; // Hide status icon
                        });
                }

                // Function to highlight search terms
                function highlightSearchTerms(searchTerm) {
                    if (!searchTerm) return;

                    const tableCells = document.querySelectorAll('td');
                    tableCells.forEach(cell => {
                        const text = cell.textContent;
                        if (text.toLowerCase().includes(searchTerm.toLowerCase())) {
                            cell.style.backgroundColor = '#fff3cd';
                            cell.style.transition = 'background-color 0.3s ease';
                        } else {
                            cell.style.backgroundColor = '';
                        }
                    });
                }

                // Highlight search terms on page load
                const searchTerm = '{{ request('search') }}';
                if (searchTerm) {
                    highlightSearchTerms(searchTerm);
                }
            }
        });
    </script>
@endsection