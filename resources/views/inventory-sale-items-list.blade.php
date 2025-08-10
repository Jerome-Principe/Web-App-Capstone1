<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Sale Items List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
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

        /* Total Price Display - Exact match from screenshot */
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
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Sale Items List</h1>
                <div>
                    <div class="d-flex justify-content-end position-relative">
                        <a href="/sales/create" class="btn btn-primary px-2"><i class="fa fa-plus mx-1"
                                aria-hidden="true"></i>Add New
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
                    <!-- Link to view all drinks -->
                    <a href="#" id="select-all-link" class="btn-style">All (0)</a>

                    <!-- Link to view all trashed sales -->
                    <a href="{{ route('sales.trashed') }}">Archived
                        ({{ App\Models\SaleItem::onlyTrashed()->count() }})
                    </a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Form to move selected drinks to trash -->
                        <form action="{{ route('sales.moveToTrash') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2" id="moveToArchiveBtn" disabled>
                                <i class="fa fa-trash"></i> Move to Archive
                            </button>
                        </form>

                        <!-- Date Filter Form -->
                        <div class="d-flex justify-content-between align-items-center">
                            <form id="date-filter-form" method="GET" action="{{ route('sales.filterByDate') }}">
                                <label for="date" class="form-label">Select Date:</label>
                                <input type="date" name="date" id="date" class="form-control d-inline-block"
                                    style="width: 200px;" required>
                                <button type="submit" class="btn btn-primary ms-2">Filter</button>
                            </form>

                            <!-- Export PDF by Date -->
                            <form method="GET" action="{{ route('sales.exportPdfByDate') }}">
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
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($items as $index => $item)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $item->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">
                                    {{ ($items->currentPage() - 1) * $items->perPage() + $loop->index + 1  }}
                                </td>
                                <td class="text-center">{{ $item->item_name }}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-center">{{ $item->price }}</td>
                                <td class="text-center">{{ $item->total }}</td>
                                <td class="text-center">
                                    <div class="date-display">
                                        <i class="fa fa-calendar"></i>
                                        <span>{{ \Carbon\Carbon::parse($item->date)->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('sales.edit', $item->id) }}" class="btn btn-sm btn-primary"><i
                                            class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update</a>
                                    <form action="{{ route('sales.destroy', $item->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mx-1"
                                            onclick="return confirm('Are you sure you want to delete this item?')"><i
                                                class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Total Price Display -->
                @if(isset($totalPrice))
                    <div class="total-income">
                        <h5><i class="fa fa-money-bill-wave"></i> Total Price: ₱{{ number_format($totalPrice, 2) }}</h5>
                    </div>
                @endif

            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mt-4">
                    <li class="page-item {{ $items->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $items->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>

                    @foreach(range(1, $items->lastPage()) as $page)
                        <li class="page-item {{ $page == $items->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $items->url($page) }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ !$items->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $items->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>

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
            const selectedIds = Array.from(selectedCheckboxes).map(input => input.value);
            document.getElementById('selectedIds').value = selectedIds.join(',');

            // Enable/disable move to archive button
            const moveToArchiveBtn = document.getElementById('moveToArchiveBtn');
            moveToArchiveBtn.disabled = count === 0;

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

    </html>
@endsection