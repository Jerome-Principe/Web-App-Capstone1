<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Archived</title>
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
            margin-bottom: 24px;
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
            background: white;
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            margin: 20px 0;
        }

        .empty-state i {
            font-size: 64px;
            color: #333;
            margin-bottom: 24px;
            display: block;
        }

        .empty-state h5 {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 12px;
            color: #333;
            margin: 0 0 12px 0;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
            color: #666;
        }

        /* Text utilities */
        .text-muted {
            color: #6c757d !important;
        }

        /* Enhanced table styles for full message display */
        .table-container {
            overflow-x: auto;
            border: 1px solid #e1e5e9;
            border-radius: 4px;
            max-width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 800px;
            /* Ensure minimum width for readability */
        }

        .table-container table th {
            background: #f8f9fa !important;
            color: #333 !important;
            font-weight: 500 !important;
            padding: 16px 12px !important;
            text-align: center !important;
            border-bottom: 1px solid #e1e5e9 !important;
            font-size: 13px !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .table-container table td {
            padding: 16px 12px !important;
            border-bottom: 1px solid #f1f3f4 !important;
            vertical-align: middle !important;
            text-align: center !important;
        }

        .table-container tbody tr:hover {
            background: #f8f9fa !important;
        }

        /* Message column specific styling */
        .table-container table td:nth-last-child(2) {
            max-width: 400px !important;
            word-wrap: break-word !important;
            white-space: pre-wrap !important;
            line-height: 1.4 !important;
            padding: 16px 12px !important;
            text-align: center !important;
        }

        /* Fade animations */
        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Responsive table improvements */
        @media (max-width: 1200px) {
            .table-container {
                overflow-x: auto;
            }

            table {
                min-width: 1000px;
            }
        }

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

            table {
                min-width: 1200px;
                /* Wider minimum for mobile to accommodate full content */
            }
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
        <div class="main-wrapper">
            <div class="content-card">
                <div class="table-section">
                    <h2>Archived</h2>

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

                    <!-- Filter options -->
                    <div class="filter-options">
                        <div class="filter-links">
                            <!-- Link to view all announcements -->
                            <a href="#" id="select-all-link" class="active">All (0)</a>

                            <!-- Link to view all trashed announcements -->
                            <a href="{{ route('feedback.trashed') }}">Archived
                                ({{App\Models\Feedback::onlyTrashed()->count()}})
                            </a>
                        </div>

                        <div>
                            @csrf
                            @method('DELETE')
                            <div class="d-flex align-items-center">
                                <!-- Button to restore selected Feedback -->
                                <form action="{{ route('feedback.restoreBulk') }}" method="POST" id="restore-selected-form">
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
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th style="width: 60px;">ID</th>
                                    <th style="width: 120px;">Name</th>
                                    <th style="width: 180px;">Email</th>
                                    <th style="width: 200px;">Subject</th>
                                    <th>Message</th>
                                    <th style="width: 120px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($trashedFeedback as $feedbacks)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $feedbacks->id }}"
                                                onchange="updateSelectionCount()">
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ ($trashedFeedback->currentPage() - 1) * $trashedFeedback->perPage() + $loop->index + 1 }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>{{ $feedbacks->name }}</strong>
                                        </td>
                                        <td>{{ $feedbacks->email }}</td>
                                        <td>{{ $feedbacks->subject }}</td>
                                        <td style="max-width: 400px; word-wrap: break-word; white-space: pre-wrap;">
                                            {{ $feedbacks->message }}
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <form action="{{ route('feedback.restore', $feedbacks->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fa fa-undo"></i> Restore
                                                    </button>
                                                </form>
                                                <form action="{{ route('feedback.forceDelete', $feedbacks->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to permanently delete this feedback?')">
                                                        <i class="fa fa-trash"></i> Delete Permanently
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        @if($trashedFeedback->hasPages())
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $trashedFeedback->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $trashedFeedback->previousPageUrl() }}">
                                            Previous
                                        </a>
                                    </li>

                                    @foreach(range(1, $trashedFeedback->lastPage()) as $page)
                                        <li class="page-item {{ $page == $trashedFeedback->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $trashedFeedback->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <li class="page-item {{ !$trashedFeedback->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $trashedFeedback->nextPageUrl() }}">
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
    </script>

@endsection