@extends('layouts.master')

@section('content')
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
                <a href="{{ route('expenses.index') }}">All ({{ App\Models\Expense::count() }})</a>
                <a href="{{ route('expenses.trashed') }}">Archived ({{ App\Models\Expense::onlyTrashed()->count() }})</a>
            </div>

            <div>
                @csrf
                @method('DELETE')
                <div class="d-flex align-items-center">
                    <!-- Button to restore selected expenses -->
                    <form action="{{ route('expenses.restoreBulk') }}" method="POST" id="restore-selected-form">
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
                        <th class="text-center">Date</th>
                        <th class="text-center">Expense Description</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Payment Method</th>
                        <th class="text-center">Deleted At</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trashedExpenses as $expense)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="selected[]" value="{{ $expense->id }}"
                                    onchange="updateSelectionCount()" />
                            </td>
                            <td class="text-center">
                                {{ ($trashedExpenses->currentPage() - 1) * $trashedExpenses->perPage() + $loop->index + 1 }}
                            </td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                            <td class="text-center">{{ $expense->expense_description }}</td>
                            <td class="text-center">₱{{ number_format($expense->amount, 2) }}</td>
                            <td class="text-center">{{ $expense->payment_method }}</td>
                            <td class="text-center">{{ $expense->deleted_at->format('M d, Y h:i A') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <form action="{{ route('expenses.restore', $expense->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Restore</button>
                                    </form>
                                    <form action="{{ route('expenses.forceDelete', $expense->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to permanently delete this expense?')">
                                            Delete Permanently
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No archived expenses found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($trashedExpenses->hasPages())
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4 mb-4">
                        <li class="page-item {{ $trashedExpenses->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $trashedExpenses->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $trashedExpenses->lastPage()) as $page)
                            <li class="page-item {{ $page == $trashedExpenses->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $trashedExpenses->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$trashedExpenses->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $trashedExpenses->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            @endif
        </div>
    </div>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
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

        .filter-options a:hover {
            text-decoration: underline;
        }

        .table-container {
            overflow-x: auto;
            white-space: nowrap;
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

        .custom-alert-message {
            padding: 10px 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .custom-alert-message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .custom-alert-message.fade-out {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .pagination .page-link {
            color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
        }
    </style>

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

        // Ensure the form doesn't submit if no expenses are selected
        document.getElementById('restore-selected-form').addEventListener('submit', function (e) {
            const selectedIds = document.getElementById('selectedIds').value;
            if (!selectedIds) {
                alert('Please select at least one expense to restore.');
                e.preventDefault(); // Prevent form submission
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            updateSelectionCount();
        });
    </script>
@endsection