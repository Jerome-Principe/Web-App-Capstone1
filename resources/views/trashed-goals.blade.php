<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Archived Goals</title>
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

        .custom-alert-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px 15px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 15px;
            position: relative;
            animation: slideIn 0.3s ease-out;
        }

        .custom-alert-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .custom-alert-message.fade-out {
            animation: fadeOut 0.5s ease-out forwards;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Archived Goals</h1>

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
                    <a href="{{ route('goals.index') }}">All ({{ App\Models\Goal::count() }})</a>
                    <a href="{{ route('goals.trashed') }}">Archived
                        ({{ App\Models\Goal::onlyTrashed()->count() }})</a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Button to restore selected goals -->
                        <form action="{{ route('goals.restoreBulk') }}" method="POST" id="restore-selected-form">
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
                            <th class="text-center">Status</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Starting Weight (Kg)</th>
                            <th class="text-center">Starting Date</th>
                            <th class="text-center">Current Weight (Kg)</th>
                            <th class="text-center">Goal Weight (Kg)</th>
                            <th class="text-center">Weekly Goal (Kg)</th>
                            <th class="text-center">Activity</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($trashedGoals as $goal)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $goal->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">
                                    {{ ($trashedGoals->currentPage() - 1) * $trashedGoals->perPage() + $loop->index + 1 }}
                                </td>
                                <td class="text-center">{{ $goal->status ?? 'Archived' }}</td>
                                <td class="text-center">{{ $goal->name ?? 'N/A' }}</td>
                                <td class="text-center">{{ $goal->starting_weight ?? 'N/A' }}</td>
                                <td class="text-center">{{ $goal->starting_date ? \Carbon\Carbon::parse($goal->starting_date)->format('M d, Y') : 'N/A' }}</td>
                                <td class="text-center">{{ $goal->current_weight ?? 'N/A' }}</td>
                                <td class="text-center">{{ $goal->goal_weight ?? 'N/A' }}</td>
                                <td class="text-center">{{ $goal->weekly_goal ?? 'N/A' }}</td>
                                <td class="text-center">{{ $goal->activity ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="{{ route('goals.restore', $goal->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                        </form>
                                        <form action="{{ route('goals.forceDelete', $goal->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to permanently delete this goal?')">
                                                Delete Permanently
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">No archived goals found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @if($trashedGoals->hasPages())
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4 mb-4">
                            <li class="page-item {{ $trashedGoals->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $trashedGoals->previousPageUrl() }}" tabindex="-1">Previous</a>
                            </li>

                            @foreach(range(1, $trashedGoals->lastPage()) as $page)
                                <li class="page-item {{ $page == $trashedGoals->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $trashedGoals->url($page) }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ !$trashedGoals->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $trashedGoals->nextPageUrl() }}">Next</a>
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

        // Ensure the form doesn't submit if no goals are selected
        document.getElementById('restore-selected-form').addEventListener('submit', function (e) {
            const selectedIds = document.getElementById('selectedIds').value;
            if (!selectedIds) {
                alert('Please select at least one goal to restore.');
                e.preventDefault(); // Prevent form submission
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            updateSelectionCount();
        });
    </script>

@endsection
