<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Expenses Management</title>
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

        .date-text,
        .time-text {
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

        .custom-alert-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px 20px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 20px;
            position: relative;
        }

        .custom-alert-message.fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>
@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <div class="d-flex align-items-center gap-3">
                    <h1 class="mb-0">Expenses Management</h1>
                    <button type="button" class="btn btn-primary px-3" data-bs-toggle="modal"
                        data-bs-target="#addExpenseModal">
                        <i class="fa fa-plus mx-1" aria-hidden="true"></i>Add New
                    </button>
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
                    <a href="#" id="select-all-link" class="active-filter">All ({{ $expenses->total() }})</a>
                    <a href="{{ route('expenses.trashed') }}">Archived ({{App\Models\Expense::onlyTrashed()->count()}})</a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Form to move selected expenses to trash -->
                        <form action="{{ route('expenses.moveToTrash') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2" id="moveToArchiveBtn" disabled>
                                <i class="fa fa-trash"></i> Move to Archive
                            </button>
                        </form>

                        <!-- Date Filter Form -->
                        <div class="d-flex justify-content-between align-items-center">
                            <form id="date-filter-form" method="GET" action="{{ route('expenses.filterByDate') }}">
                                <label for="date" class="form-label">Select Date:</label>
                                <input type="date" name="date" id="date" class="form-control d-inline-block"
                                    style="width: 200px;" required>
                                <button type="submit" class="btn btn-primary ms-2">Filter</button>
                            </form>

                            <!-- Export PDF by Date -->
                            <form method="GET" action="{{ route('expenses.exportPdfByDate') }}">
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
                            <th class="text-center">Date</th>
                            <th class="text-center">Expenses</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Payment Method</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $expense->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($expense->date)->format('F d, Y') }}</td>
                                <td class="text-center">{{ $expense->expense_description }}</td>
                                <td class="text-center">₱{{ number_format($expense->amount, 2) }}</td>
                                <td class="text-center">{{ $expense->payment_method }}</td>
                                <td class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editExpenseModal{{ $expense->id }}">
                                        <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                    </button>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mx-1"
                                            onclick="return confirm('Are you sure you want to delete this expense?')">
                                            <i class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No expenses found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="summary-section">
                    <div class="summary-content">
                        <div class="summary-item">
                            <div class="summary-label">Date Selected</div>
                            <div class="summary-value">
                                {{ $date ? \Carbon\Carbon::parse($date)->format('F d, Y') : 'All Dates' }}
                            </div>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-item">
                            <div class="summary-label">Total Expenses</div>
                            <div class="summary-value">{{ $expenses->total() }}</div>
                        </div>
                        <div class="summary-divider"></div>
                        <div class="summary-item">
                            <div class="summary-label">Total Amount Expenses</div>
                            <div class="summary-value">₱{{ number_format($totalAmount ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>

                @if($expenses->hasPages())
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4">
                            <li class="page-item {{ $expenses->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $expenses->previousPageUrl() }}" tabindex="-1">Previous</a>
                            </li>

                            @foreach(range(1, $expenses->lastPage()) as $page)
                                <li class="page-item {{ $page == $expenses->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $expenses->url($page) }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ !$expenses->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $expenses->nextPageUrl() }}">Next</a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>
        </div>

        <!-- Add Expense Modal -->
        <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExpenseModalLabel">Add New Expense</h5>
                        <button type="button" class="btn-close" onclick="closeModal('addExpenseModal')"
                            aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ route('expenses.store') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="modal_date" class="form-label">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="modal_date"
                                    name="date" value="{{ old('date') }}" required>
                                @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="modal_expense_description" class="form-label">Expense Description</label>
                                <input type="text" class="form-control @error('expense_description') is-invalid @enderror"
                                    id="modal_expense_description" name="expense_description"
                                    value="{{ old('expense_description') }}" required>
                                @error('expense_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="modal_amount" class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                    id="modal_amount" name="amount" value="{{ old('amount') }}" required>
                                @error('amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="modal_payment_method" class="form-label">Payment Method</label>
                                <select class="form-control @error('payment_method') is-invalid @enderror"
                                    id="modal_payment_method" name="payment_method" required>
                                    <option value="">Select Payment Method</option>
                                    <option value="Cash" {{ old('payment_method') == 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Credit Card" {{ old('payment_method') == 'Credit Card' ? 'selected' : '' }}>
                                        Credit Card</option>
                                    <option value="Debit Card" {{ old('payment_method') == 'Debit Card' ? 'selected' : '' }}>
                                        Debit
                                        Card</option>
                                    <option value="Bank Transfer" {{ old('payment_method') == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="Check" {{ old('payment_method') == 'Check' ? 'selected' : '' }}>Check
                                    </option>
                                    <option value="Digital Wallet" {{ old('payment_method') == 'Digital Wallet' ? 'selected' : '' }}>Digital Wallet</option>
                                </select>
                                @error('payment_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                onclick="closeModal('addExpenseModal')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Expense</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Expense Modal -->
        @foreach($expenses as $expense)
            <div class="modal fade" id="editExpenseModal{{ $expense->id }}" tabindex="-1"
                aria-labelledby="editExpenseModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editExpenseModalLabel">Edit Expenses</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('expenses.update', $expense->id) }}"
                            id="editExpenseForm{{ $expense->id }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="edit_modal_date{{ $expense->id }}" class="form-label">Date</label>
                                    <input type="date" class="form-control @error('date') is-invalid @enderror"
                                        id="edit_modal_date{{ $expense->id }}" name="date"
                                        value="{{ $expense->date ? \Carbon\Carbon::parse($expense->date)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d') }}"
                                        required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="edit_modal_expense_description{{ $expense->id }}" class="form-label">Expense
                                        Description</label>
                                    <input type="text" class="form-control @error('expense_description') is-invalid @enderror"
                                        id="edit_modal_expense_description{{ $expense->id }}" name="expense_description"
                                        value="{{ $expense->expense_description }}" required>
                                    @error('expense_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="edit_modal_amount{{ $expense->id }}" class="form-label">Amount</label>
                                    <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror"
                                        id="edit_modal_amount{{ $expense->id }}" name="amount" value="{{ $expense->amount }}"
                                        required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="edit_modal_payment_method{{ $expense->id }}" class="form-label">Payment
                                        Method</label>
                                    <select class="form-control @error('payment_method') is-invalid @enderror"
                                        id="edit_modal_payment_method{{ $expense->id }}" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="Cash" {{ $expense->payment_method == 'Cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="Credit Card" {{ $expense->payment_method == 'Credit Card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="Debit Card" {{ $expense->payment_method == 'Debit Card' ? 'selected' : '' }}>Debit Card</option>
                                        <option value="Bank Transfer" {{ $expense->payment_method == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="Check" {{ $expense->payment_method == 'Check' ? 'selected' : '' }}>Check
                                        </option>
                                        <option value="Digital Wallet" {{ $expense->payment_method == 'Digital Wallet' ? 'selected' : '' }}>Digital Wallet</option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" form="editExpenseForm{{ $expense->id }}" class="btn btn-primary">Update
                                    Expense</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </body>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>

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

        document.getElementById('date').addEventListener('change', function () {
            document.getElementById('date-filter-form').submit();
        });

        document.getElementById('date').addEventListener('change', function () {
            const pdfDateField = document.getElementById('pdf-date');
            pdfDateField.value = this.value;
        });

        // Modal functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Get the modal
            const modal = document.getElementById('addExpenseModal');

            // When the modal is shown, set today's date as default
            modal.addEventListener('shown.bs.modal', function () {
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('modal_date').value = today;
            });

            // When the modal is hidden, clear the form
            modal.addEventListener('hidden.bs.modal', function () {
                document.getElementById('modal_date').value = '';
                document.getElementById('modal_expense_description').value = '';
                document.getElementById('modal_amount').value = '';
                document.getElementById('modal_payment_method').value = '';

                // Clear any error states
                const invalidInputs = modal.querySelectorAll('.is-invalid');
                invalidInputs.forEach(input => {
                    input.classList.remove('is-invalid');
                });
            });

            // Set current date for the main date filter input
            const dateFilterInput = document.getElementById('date');
            if (dateFilterInput) {
                const today = new Date().toISOString().split('T')[0];
                dateFilterInput.value = today;
            }
        });

        // Close modal function (kept for add expense modal)
        function closeModal(modalId) {
            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
            if (modal) {
                modal.hide();
            }
        }

        // Function to set current date for edit modals
        function setCurrentDateForEditModals() {
            const today = new Date().toISOString().split('T')[0];
            const editModals = document.querySelectorAll('[id^="editExpenseModal"]');

            editModals.forEach(modal => {
                modal.addEventListener('shown.bs.modal', function () {
                    const dateInput = this.querySelector('input[type="date"]');
                    if (dateInput && !dateInput.value) {
                        dateInput.value = today;
                    }
                });
            });
        }

        // Initialize date functionality when page loads
        document.addEventListener('DOMContentLoaded', function () {
            setCurrentDateForEditModals();
        });

    </script>

@endsection