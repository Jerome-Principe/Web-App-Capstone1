<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Add Walk-in Clients</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .summary {
            margin-top: 20px;
        }
    </style>
</head>
@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Walkin Clients</h1>
                <div>
                    <div class="d-flex justify-content-end position-relative">
                        <a href="/walkin" class="btn btn-primary px-2"><i class="fa fa-plus mx-1" aria-hidden="true"></i>Add
                            New
                        </a>
                    </div>
                </div>

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
            </div>

            <div class="filter-options">
                <div class="filter-links">
                    <a href="#" id="select-all-link">All (0)</a>
                    <a href="{{ route('walkins.trashed') }}">Trashed
                        ({{App\Models\Walkin::onlyTrashed()->count()}})
                    </a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Form to move selected walkins to trash -->
                        <form action="{{ route('walkins.moveToTrash') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2">
                                <i class="fa fa-trash"></i> Move to Trash
                            </button>
                        </form>

                        <!-- Date Filter Form -->
                        <div class="d-flex justify-content-between align-items-center">
                            <form id="date-filter-form" method="GET" action="{{ route('walkin.filterByDate') }}">
                                <label for="date" class="form-label">Select Date:</label>
                                <input type="date" name="date" id="date" class="form-control d-inline-block"
                                    style="width: 200px;" required>
                                <button type="submit" class="btn btn-primary ms-2">Filter</button>
                            </form>

                            <!-- Export PDF by Date -->
                            <form method="GET" action="{{ route('walkin.exportPdfByDate') }}">
                                <input type="hidden" name="date" id="pdf-date" value="{{ request('date') }}">
                                <button type="submit" class="btn btn-success ms-2">Export PDF</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Full Name</th>
                            <th class="text-center">Age</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Payment</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Time</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($walkins as $index => $walkin)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $walkin->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">{{ $walkin->id }}</td>
                                <td class="text-center">
                                    {{ $walkin->lastname . ', ' . $walkin->firstname . ' ' . $walkin->middlename }}
                                </td>
                                <td class="text-center">{{ $walkin->age }}</td>
                                <td class="text-center">{{ $walkin->amount }}</td>
                                <td class="text-center">{{ $walkin->payment }}</td>
                                <td class="text-center">{{ $walkin->date }}</td>
                                <td class="text-center">{{ $walkin->time }}</td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('walkins.edit', $walkin->id) }}" class="btn btn-sm btn-primary"><i
                                            class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update</a>
                                    <form action="{{ route('walkins.destroy', $walkin->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mx-1"
                                            onclick="return confirm('Are you sure you want to delete this walk-in client?')"><i
                                                class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <h5>Date Selected: {{ $date ?? 'All Dates' }}</h5>
                    <h5>Total Names: {{ $totalNames ?? $walkins->total() }}</h5>
                    <h5>Total Amount: {{ $totalAmount ?? 0 }}</h5>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item {{ $walkins->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $walkins->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $walkins->lastPage()) as $page)
                            <li class="page-item {{ $page == $walkins->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $walkins->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$walkins->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $walkins->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
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

        // Add functionality for the "All (0)" link click
        document.getElementById('select-all-link').addEventListener('click', function (e) {
            e.preventDefault();
            const isChecked = this.textContent.includes('0') || this.textContent.includes('All (0)');
            const selectAllCheckbox = document.querySelector('input[type="checkbox"]');
            selectAllCheckbox.checked = isChecked;
            toggleSelectAll(selectAllCheckbox);
        });

        // Ensure the form doesn't submit if no appointments are selected
        document.getElementById('restore-selected-form').addEventListener('submit', function (e) {
            const selectedIds = document.getElementById('selectedIds').value;
            if (!selectedIds) {
                alert('Please select at least one appointments to restore.');
                e.preventDefault(); // Prevent form submission
            }
        });

        document.getElementById('date').addEventListener('change', function () {
            document.getElementById('date-filter-form').submit();
        });

        document.getElementById('date').addEventListener('change', function () {
            const pdfDateField = document.getElementById('pdf-date');
            pdfDateField.value = this.value;
        });

    </script>

@endsection