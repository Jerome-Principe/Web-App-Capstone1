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
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1400px;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
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
            min-width: 1200px;
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

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 20px;
            display: block;
        }

        .empty-state h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #495057;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
            color: #6c757d;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Archived</h1>
                <small style="color: #6c757d; font-style: italic; margin-left: 10px;">
                    <i class="fas fa-sort-amount-down"></i> Sorted by most recent first
                </small>

                @if(session('success'))
                    <div class="custom-alert-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="custom-alert-message error">
                        {{ session('error') }}
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
                    <a href="{{ route('mobile-feedback.index') }}">All ({{ $activeCount ?? 0 }})</a>
                    <a href="{{ route('mobile-feedback.trashed') }}">Archived
                        ({{ $trashedMobileFeedbacks->total() }})</a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Button to restore selected mobile feedback -->
                        <form action="{{ route('mobile-feedback.restoreBulk') }}" method="POST" id="restore-selected-form">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-success mx-2">
                                <i class="fa fa-undo"></i> Restore Selected
                            </button>
                        </form>

                        <!-- Search functionality -->
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
                            <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                            <th class="text-center">
                                ID <i class="fas fa-sort-amount-down" style="color: #6c757d; font-size: 0.8em;"
                                    title="Sorted by most recent first"></i>
                            </th>
                            <th class="text-center">Username</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Subject</th>
                            <th class="text-center">Message</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashedMobileFeedbacks as $mobileFeedback)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $mobileFeedback->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">
                                    {{ ($trashedMobileFeedbacks->currentPage() - 1) * $trashedMobileFeedbacks->perPage() + $loop->index + 1 }}
                                </td>
                                <td class="text-center">
                                    <strong>{{ $mobileFeedback->username }}</strong>
                                </td>
                                <td class="text-center">{{ $mobileFeedback->email }}</td>
                                <td class="text-center">{{ $mobileFeedback->subject }}</td>
                                <td class="text-center">
                                    {{ $mobileFeedback->message }}
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('mobile-feedback.restore', $mobileFeedback->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>
                                        <form action="{{ route('mobile-feedback.forceDelete', $mobileFeedback->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to permanently delete this mobile feedback?')">
                                                Delete Permanently
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="empty-state">
                                        <i class="fa fa-mobile-alt"></i>
                                        <h5>No archived mobile feedback found</h5>
                                        <p>No mobile feedback records have been archived yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($trashedMobileFeedbacks->hasPages())
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4 mb-4">
                            <li class="page-item {{ $trashedMobileFeedbacks->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $trashedMobileFeedbacks->previousPageUrl() }}"
                                    tabindex="-1">Previous</a>
                            </li>

                            @foreach(range(1, $trashedMobileFeedbacks->lastPage()) as $page)
                                <li class="page-item {{ $page == $trashedMobileFeedbacks->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $trashedMobileFeedbacks->url($page) }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ !$trashedMobileFeedbacks->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $trashedMobileFeedbacks->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                @endif

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
            const selectedIds = Array.from(selectedCheckboxes).map(input => input.value);
            document.getElementById('selectedIds').value = selectedIds.join(',');
        }

        // Ensure the form doesn't submit if no mobile feedback is selected
        document.getElementById('restore-selected-form').addEventListener('submit', function (e) {
            const selectedIds = document.getElementById('selectedIds').value;
            if (!selectedIds) {
                alert('Please select at least one mobile feedback to restore.');
                e.preventDefault(); // Prevent form submission
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            updateSelectionCount();
        });
    </script>

@endsection