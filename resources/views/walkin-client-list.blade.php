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
            margin: 30px auto;
            background-color: white;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            border: 1px solid #e1e5e9;
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

        .filter-options a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .filter-options a:hover {
            background: #e3f2fd;
        }

        /* Button-style link for "All" filter */
        .filter-links a.btn-style {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            border: 1px solid #007bff;
            pointer-events: none;
            cursor: default;
        }

        /* Active filter styling - looks like button but not clickable */
        .filter-links a.active-filter {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            border: none;
            pointer-events: none;
            cursor: default;
            display: inline-block;
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
            text-align: center;
            border-bottom: 1px solid #e1e5e9;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            text-align: center;
            vertical-align: middle;
        }

        /* Hover effect */
        tbody tr:hover {
            background: #f8f9fa;
            cursor: pointer;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #007bff;
            margin: 0;
        }

        .summary {
            margin-top: 24px;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
        }

        .summary h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        /* Compact Summary Section */
        .summary-section {
            margin-top: 16px;
            padding: 12px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.12);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .summary-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(5px);
        }

        .summary-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .summary-item {
            text-align: center;
            flex: 1;
        }

        .summary-label {
            font-size: 11px;
            font-weight: 500;
            opacity: 0.85;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .summary-value {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .summary-divider {
            width: 1px;
            height: 24px;
            background: rgba(255, 255, 255, 0.25);
        }

                /* Date Time Display Styling */
        .date-time-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            color: #6c757d;
        }

        .date-time-display i {
            color: #495057;
            font-size: 12px;
        }

        .date-text, .time-text {
            color: #6c757d;
            font-weight: 400;
        }

        .separator {
            color: #adb5bd;
            margin: 0 2px;
        }

        /* Responsive design for summary */
        @media (max-width: 768px) {
            .summary-content {
                flex-direction: column;
                gap: 8px;
            }
            
            .summary-divider {
                display: none;
            }
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
                    <a href="#" id="select-all-link" class="active-filter">All (0)</a>
                    <a href="{{ route('walkins.trashed') }}">Archived
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
                                <i class="fa fa-trash"></i> Move to Archive
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
                            <th class="text-center">Date & Time</th>
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
                                <td class="text-center">
                                    <div class="date-time-display">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        <span
                                            class="date-text">{{ \Carbon\Carbon::parse($walkin->date)->format('M d, Y') }}</span>
                                        <span class="separator">|</span>
                                        <span
                                            class="time-text">{{ \Carbon\Carbon::parse($walkin->time)->format('h:i A') }}</span>
                                    </div>
                                </td>
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

                <div class="summary-section">
                    <div class="summary-content">
                        <div class="summary-item">
                            <div class="summary-label">Date Selected</div>
                            <div class="summary-value">{{ $date ?? 'All Dates' }}</div>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-item">
                            <div class="summary-label">Total Names</div>
                            <div class="summary-value">{{ $totalNames ?? $walkins->total() }}</div>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-item">
                            <div class="summary-label">Total Amount</div>
                            <div class="summary-value">₱{{ number_format($totalAmount ?? 0, 2) }}</div>
                        </div>
                    </div>
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

        document.getElementById('date').addEventListener('change', function () {
            document.getElementById('date-filter-form').submit();
        });

        document.getElementById('date').addEventListener('change', function () {
            const pdfDateField = document.getElementById('pdf-date');
            pdfDateField.value = this.value;
        });

    </script>

@endsection