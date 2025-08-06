@extends('layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Archived Expenses</h4>
                        <a href="{{ route('expenses.index') }}" class="btn btn-primary">Back to Expenses</a>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <form action="{{ route('expenses.restoreBulk') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="selected" id="selectedIds">
                                <button type="submit" class="btn btn-success" id="restoreBtn" disabled>
                                    <i class="fa fa-undo"></i> Restore Selected
                                </button>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                                        <th>Date</th>
                                        <th>Expense Description</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Deleted At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($trashedExpenses as $expense)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="selected[]" value="{{ $expense->id }}"
                                                    onchange="updateSelectionCount()" />
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                                            <td>{{ $expense->expense_description }}</td>
                                            <td>₱{{ number_format($expense->amount, 2) }}</td>
                                            <td>{{ $expense->payment_method }}</td>
                                            <td>{{ $expense->deleted_at->format('M d, Y h:i A') }}</td>
                                            <td>
                                                <form action="{{ route('expenses.restore', $expense->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fa fa-undo"></i> Restore
                                                    </button>
                                                </form>
                                                <form action="{{ route('expenses.forceDelete', $expense->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to permanently delete this expense?')">
                                                        <i class="fa fa-trash"></i> Delete Permanently
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No archived expenses found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($trashedExpenses->hasPages())
                            <div class="d-flex justify-content-center">
                                {{ $trashedExpenses->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            checkboxes.forEach(item => item.checked = checkbox.checked);
            updateSelectionCount();
        }

        function updateSelectionCount() {
            const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const count = selectedCheckboxes.length;
            const selectedIds = Array.from(selectedCheckboxes).map(input => input.value);
            document.getElementById('selectedIds').value = selectedIds.join(',');

            const restoreBtn = document.getElementById('restoreBtn');
            restoreBtn.disabled = count === 0;

            const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
            const totalCount = document.querySelectorAll('input[name="selected[]"]').length;
            selectAllCheckbox.checked = count === totalCount && totalCount > 0;
            selectAllCheckbox.indeterminate = count > 0 && count < totalCount;
        }

        document.addEventListener("DOMContentLoaded", function () {
            updateSelectionCount();
        });
    </script>
@endsection