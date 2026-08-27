<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{asset('assets/images/muscle.png')}}" type="image/png">
    <title>Defect Machines List</title>
    <style>
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

        .content-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 40px;
            margin-bottom: 32px;
            border: 1px solid #e1e5e9;
        }

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

        .header-section {
            display: flex;
            justify-content: flex-start;
            text-align: left;
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

        .date-info {
            font-size: 12px;
            color: gray;
        }

        /* Enhanced Date Display Styling */
        .date-display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: #6c757d;
            font-size: 14px;
        }

        .date-display i {
            font-size: 14px;
            color: #6c757d;
        }

        .date-display span {
            color: #6c757d;
            font-weight: 400;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Defect Machines List</h1>
                <p>Monitor machine defects and issues</p>
            </div>

            <!-- Defect Machines Section -->
            <div class="content-card">
                <div class="header-section">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <h1 class="card-title mb-0" style="font-size: 20px; font-weight: 500; color: #333;">Defect Machines
                            List</h1>
                        <a href="/machine-defects/create" class="btn btn-primary px-2"><i class="fa fa-plus mx-1"
                                aria-hidden="true"></i>Add New
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="custom-alert-message">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="custom-alert-message">
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

                <div class="filter-options">
                    <div class="filter-links">
                        <!-- Link to view all machines defect -->
                        <a href="#" id="select-all-link" class="btn-style">All (0)</a>
                    </div>

                    <div>
                        <!-- Date Filter Form -->
                        <div class="d-flex justify-content-between align-items-center">
                            <form id="date-filter-form" method="GET" action="{{ route('machine-defects.filterByDate') }}">
                                <label for="date" class="form-label">Select Date:</label>
                                <input type="date" name="date" id="date" class="form-control d-inline-block"
                                    style="width: 200px;" required>
                                <button type="submit" class="btn btn-primary ms-2">Filter</button>
                            </form>

                            <!-- Export PDF by Date -->
                            <form method="GET" action="{{ route('machine-defects.exportPdfByDate') }}">
                                <input type="hidden" name="date" id="pdf-date" value="{{ request('date') }}">
                                <button type="submit" class="btn btn-success ms-2">Export PDF</button>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                                <th class="text-center">ID</th>
                                <th class="text-center">Item Name</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Defect</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($machineDefects as $index => $machineDefect)
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="selected[]"
                                            value="{{ $machineDefect->id }}" onchange="updateSelectionCount()" /></td>
                                    <td class="text-center">{{ $machineDefect->machine->id }}</td>
                                    <td class="text-center">{{ $machineDefect->machine->item_name }}</td>
                                    <td class="text-center">{{ $machineDefect->quantity }}</td>
                                    <td class="text-center">{{ $machineDefect->defect }}</td>
                                    <td class="text-center">
                                        <div class="date-display">
                                            <i class="fa fa-calendar"></i>
                                            <span>{{ \Carbon\Carbon::parse($machineDefect->date)->format('M d, Y') }}</span>
                                        </div>
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('machine-defects.edit', $machineDefect->id) }}"
                                            class="btn btn-sm btn-outline-primary me-2">
                                            <i class="fa fa-pencil mr-1"></i>
                                            Update
                                        </a>
                                        <form action="{{ route('machine-defects.destroy', $machineDefect->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Are you sure you want to delete this defect record? This will restore the quantity to the machine.')">
                                                <i class="fa fa-trash mr-1"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4 mb-4">
                            <li class="page-item {{ $machineDefects->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $machineDefects->previousPageUrl() }}"
                                    tabindex="-1">Previous</a>
                            </li>

                            @foreach(range(1, $machineDefects->lastPage()) as $page)
                                <li class="page-item {{ $page == $machineDefects->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $machineDefects->url($page) }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ !$machineDefects->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $machineDefects->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>
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
            const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

            document.getElementById('select-all-link').textContent = `All (${count}/${totalCount})`;

            // Update select all checkbox
            const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
            selectAllCheckbox.checked = count === totalCount && totalCount > 0;
            selectAllCheckbox.indeterminate = count > 0 && count < totalCount;
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

        document.getElementById('date').addEventListener('change', function () {
            document.getElementById('date-filter-form').submit();
        });

        document.getElementById('date').addEventListener('change', function () {
            const pdfDateField = document.getElementById('pdf-date');
            pdfDateField.value = this.value;
        });
    </script>

    </html>

@endsection