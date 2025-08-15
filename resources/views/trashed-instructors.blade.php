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
                    <a href="{{ route('instructors.index') }}">All ({{ App\Models\Instructor::count() }})</a>
                    <a href="{{ route('instructors.trashed') }}">Archived
                        ({{ App\Models\Instructor::onlyTrashed()->count() }})</a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Button to restore selected instructors -->
                        <form action="{{ route('instructors.restore.bulk') }}" method="POST" id="restore-selected-form">
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
                            <th class="text-center">ID</th>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Contact Number</th>
                            <th class="text-center">Expertise</th>
                            <th class="text-center">Session</th>
                            <th class="text-center">Rates</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashedInstructors as $instructor)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $instructor->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">
                                    {{ ($trashedInstructors->currentPage() - 1) * $trashedInstructors->perPage() + $loop->index + 1 }}
                                </td>
                                <td class="text-center">{{ $instructor->first_name }}</td>
                                <td class="text-center">{{ $instructor->last_name }}</td>
                                <td class="text-center">{{ $instructor->contact_number }}</td>
                                <td class="text-center">{{ $instructor->expertise ?? 'N/A' }}</td>
                                <td class="text-center">{{ $instructor->session }}</td>
                                <td class="text-center">₱{{ number_format($instructor->rates, 2) }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('instructors.restore', $instructor->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>
                                        <form action="{{ route('instructors.forceDelete', $instructor->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to permanently delete this instructor?')">
                                                Delete Permanently
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="empty-state">
                                        <i class="fa fa-chalkboard-teacher"></i>
                                        <h5>No archived instructors found</h5>
                                        <p>No instructor records have been archived yet</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($trashedInstructors->hasPages())
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4 mb-4">
                            <li class="page-item {{ $trashedInstructors->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $trashedInstructors->previousPageUrl() }}"
                                    tabindex="-1">Previous</a>
                            </li>

                            @foreach(range(1, $trashedInstructors->lastPage()) as $page)
                                <li class="page-item {{ $page == $trashedInstructors->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $trashedInstructors->url($page) }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ !$trashedInstructors->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $trashedInstructors->nextPageUrl() }}">Next</a>
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

        // Ensure the form doesn't submit if no instructors are selected
        document.getElementById('restore-selected-form').addEventListener('submit', function (e) {
            const selectedIds = document.getElementById('selectedIds').value;
            if (!selectedIds) {
                alert('Please select at least one instructor to restore.');
                e.preventDefault(); // Prevent form submission
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            updateSelectionCount();
        });
    </script>

@endsection