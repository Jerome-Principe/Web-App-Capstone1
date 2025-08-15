<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Feedback Management</title>
    <style>
        /* Clean Modern Design */
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
            --border-radius: 8px;
            --box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .main-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 1rem;
        }

        /* Clean Card Design */
        .content-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            width: 100%;
        }

        /* Clean Header */
        .page-header {
            text-align: center;
            margin-bottom: 1.25rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-color);
            margin: 0 0 0.25rem 0;
        }

        .page-header p {
            font-size: 0.85rem;
            color: var(--secondary-color);
            margin: 0;
        }

        /* Clean Filter Section */
        .filter-section {
            background: #f8f9fa;
            border-radius: var(--border-radius);
            padding: 0.75rem;
            margin-bottom: 1.25rem;
            border: 1px solid #e9ecef;
        }

        .filter-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .filter-tabs {
            display: flex;
            gap: 0.2rem;
            align-items: center;
        }

        .filter-tab {
            padding: 0.35rem 0.7rem;
            border-radius: 20px;
            text-decoration: none;
            color: var(--secondary-color);
            font-weight: 500;
            transition: var(--transition);
            border: 1px solid #e9ecef;
            background: white;
            font-size: 0.75rem;
        }

        .filter-tab.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .filter-tab:hover:not(.active) {
            background: #e9ecef;
            color: var(--dark-color);
        }

        .filter-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        /* Clean Buttons */
        .btn-clean {
            padding: 0.35rem 0.7rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            border: 1px solid #e9ecef;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            text-decoration: none;
            cursor: pointer;
            font-size: 0.75rem;
        }

        .btn-clean:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-primary-clean {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-light-clean {
            background: white;
            color: var(--dark-color);
            border-color: #e9ecef;
        }

        .btn-light-clean:hover {
            background: #f8f9fa;
            color: var(--primary-color);
        }

        /* Clean Search */
        .search-container {
            display: flex;
            gap: 0.3rem;
            align-items: center;
        }

        .search-input {
            padding: 0.35rem 0.7rem;
            border: 1px solid #e9ecef;
            border-radius: var(--border-radius);
            background: white;
            transition: var(--transition);
            min-width: 160px;
            font-size: 0.75rem;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(78, 115, 223, 0.1);
        }

        /* Clean Table */
        .table-container {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            border: 1px solid #e9ecef;
            width: 100%;
        }

        .table-clean {
            width: 100%;
            min-width: 100%;
            border-collapse: collapse;
            margin: 0;
            table-layout: fixed;
        }

        .table-clean th {
            background: #f8f9fa;
            color: var(--dark-color);
            font-weight: 600;
            padding: 0.6rem 0.4rem;
            text-align: center;
            border-bottom: 2px solid #e9ecef;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-clean td {
            padding: 0.6rem 0.4rem;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            transition: var(--transition);
            word-break: break-word;
            text-align: center;
        }

        .table-clean tbody tr {
            transition: var(--transition);
        }

        .table-clean tbody tr:hover {
            background: #f8f9fa;
        }

        /* Clean Checkbox */
        .custom-checkbox {
            width: 12px;
            height: 12px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        /* Clean Badge */
        .badge-clean {
            padding: 0.15rem 0.5rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.65rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-primary-clean {
            background: var(--primary-color);
            color: white;
        }

        /* Clean Star Rating */
        .star-rating-display {
            display: flex;
            gap: 1px;
            justify-content: center;
            align-items: center;
        }

        .star-rating-display .star {
            font-size: 9px;
            transition: var(--transition);
        }

        .star-rating-display .star.filled {
            color: #ffd700;
        }

        .star-rating-display .star.empty {
            color: #e3e6f0;
        }

        .rating-text {
            font-size: 0.65rem;
            color: var(--secondary-color);
            margin-top: 0.15rem;
            text-align: center;
        }

        /* Clean Action Buttons */
        .action-buttons {
            display: flex;
            gap: 0.3rem;
            justify-content: center;
        }

        .btn-action {
            padding: 0.4rem 0.6rem;
            border-radius: 4px;
            border: none;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.3rem;
            text-decoration: none;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .btn-delete {
            background: var(--danger-color);
            color: white;
        }

        .btn-action:hover {
            transform: scale(1.1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Clean Message Display */
        .message-cell {
            max-width: 350px;
            min-width: 250px;
            word-wrap: break-word;
            line-height: 1.4;
            position: relative;
            text-align: left;
        }

        .message-preview {
            display: block;
            overflow-y: auto;
            color: var(--dark-color);
            font-size: 0.8rem;
            padding: 0.5rem;
            border-radius: 4px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            margin-bottom: 0.25rem;
            min-height: 60px;
            max-height: 120px;
            text-align: left;
            white-space: pre-wrap;
            word-break: break-word;
            cursor: default;
        }

        .message-preview:hover {
            background: #e9ecef;
            border-color: var(--primary-color);
        }



        /* Custom scrollbar for message popup */
        .message-full::-webkit-scrollbar {
            width: 5px;
        }

        .message-full::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .message-full::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 3px;
        }

        .message-full::-webkit-scrollbar-thumb:hover {
            background: #5a6fd8;
        }





        /* Enhanced message preview for very long messages */
        .message-preview.long {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            position: relative;
        }

        .message-preview.long::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-top: 8px solid var(--primary-color);
            margin: 0.25rem;
        }

        /* Message popup header */
        .message-full::before {
            content: 'Full Message';
            display: block;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Scroll indicator for very long messages */
        .message-full::after {
            content: 'Scroll to read more ↓';
            display: block;
            text-align: center;
            font-size: 0.7rem;
            color: var(--secondary-color);
            margin-top: 0.75rem;
            padding-top: 0.5rem;
            border-top: 1px solid #e9ecef;
            font-style: italic;
        }

        /* Ensure table doesn't truncate content */
        .table-clean {
            table-layout: auto;
        }

        .table-clean td {
            padding: 1rem;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            transition: var(--transition);
            word-break: break-word;
        }

        /* Clean Pagination */
        .pagination-clean {
            display: flex;
            justify-content: center;
            gap: 0.15rem;
            margin-top: 0.75rem;
        }

        .page-link-clean {
            padding: 0.3rem 0.5rem;
            border: 1px solid #e9ecef;
            border-radius: 3px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            background: white;
            font-size: 0.75rem;
        }

        .page-link-clean:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .page-item.active .page-link-clean {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .page-item.disabled .page-link-clean {
            color: var(--secondary-color);
            background: #f8f9fa;
            border-color: #e9ecef;
            cursor: not-allowed;
        }

        /* Clean Alert */
        .alert-clean {
            padding: 1rem 1.5rem;
            border-radius: var(--border-radius);
            border: 1px solid #d4edda;
            font-weight: 500;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            background: #d4edda;
            color: #155724;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .table-container {
                overflow-x: auto;
            }

            .table-clean {
                min-width: 800px;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 1rem;
            }

            .content-card {
                padding: 1.5rem;
            }

            .filter-header {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-actions {
                justify-content: center;
            }

            .search-container {
                width: 100%;
            }

            .search-input {
                min-width: auto;
                width: 100%;
            }
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--secondary-color);
        }

        .empty-state i {
            font-size: 3rem;
            color: #e3e6f0;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark-color);
        }

        .empty-state p {
            font-size: 0.875rem;
            margin: 0;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-container">
            <div class="content-card">
                <div class="page-header">
                    <h1>Feedback Management</h1>
                    <p>Manage and review customer feedback and ratings</p>
                </div>

                @if(session('success'))
                    <div class="alert-clean">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="filter-section">
                    <div class="filter-header">
                        <div class="filter-tabs">
                            <a href="#" class="filter-tab active" id="select-all-link">
                                All (<span id="selection-count">0</span>/<span id="total-count">0</span>)
                            </a>
                            <a href="{{ route('feedback.trashed') }}" class="filter-tab">
                                Archived ({{ App\Models\Feedback::onlyTrashed()->count() }})
                            </a>
                        </div>

                        <div class="filter-actions">
                            <form action="{{ route('feedback.moveToTrash') }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="selected" id="selectedIds">
                                <button type="submit" class="btn-clean btn-light-clean" id="moveToArchiveBtn" disabled>
                                    <i class="fas fa-archive"></i>
                                    Move to Archive
                                </button>
                            </form>

                            <div class="search-container">
                                <input type="search" class="search-input" placeholder="Search" aria-label="Search">
                                <button class="btn-clean btn-primary-clean" type="submit">
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    @if($feedback->count() > 0)
                        <table class="table-clean">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" class="custom-checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Rating</th>
                                    <th>Message</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($feedback as $feedbacks)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="custom-checkbox" name="selected[]"
                                                value="{{ $feedbacks->id }}" onchange="updateSelectionCount()" />
                                        </td>
                                        <td>
                                            <span class="badge-clean badge-primary-clean">{{ $feedbacks->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $feedbacks->name }}</strong>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $feedbacks->email }}"
                                                style="color: var(--primary-color); text-decoration: none;">
                                                {{ $feedbacks->email }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ $feedbacks->subject ?: 'No subject' }}
                                        </td>
                                        <td>
                                            @if($feedbacks->rating)
                                                <div class="star-rating-display">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <span class="star {{ $i <= $feedbacks->rating ? 'filled' : 'empty' }}">★</span>
                                                    @endfor
                                                </div>
                                                <div class="rating-text">{{ $feedbacks->rating }}/5</div>
                                            @else
                                                <span style="color: var(--secondary-color); font-size: 0.75rem;">
                                                    No rating
                                                </span>
                                            @endif
                                        </td>
                                        <td class="message-cell">
                                            <div class="message-preview">
                                                {{ $feedbacks->message ?: 'No message' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <form action="{{ route('feedback.destroy', $feedbacks->id) }}" method="POST"
                                                    style="display: inline;"
                                                    onsubmit="return confirm('Are you sure you want to delete this feedback?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete" title="Delete Feedback">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <h3>No Feedback Found</h3>
                            <p>There are no feedback entries to display at the moment.</p>
                        </div>
                    @endif

                    @if($feedback->count() > 0)
                        <nav aria-label="Page navigation" class="pagination-clean">
                            <ul class="pagination" style="margin: 0; list-style: none; display: flex; gap: 0.25rem;">
                                <li class="page-item {{ $feedback->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link-clean" href="{{ $feedback->previousPageUrl() }}" tabindex="-1">
                                        Previous
                                    </a>
                                </li>

                                @foreach ($feedback->getUrlRange(1, $feedback->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $feedback->currentPage() ? 'active' : '' }}">
                                        <a class="page-link-clean" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ !$feedback->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link-clean" href="{{ $feedback->nextPageUrl() }}">
                                        Next
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>

        <script>
            // Clean JavaScript functionality
            document.addEventListener("DOMContentLoaded", function () {
                // Initialize the page
                updateSelectionCount();

                // Auto-hide success messages
                setTimeout(function () {
                    const alert = document.querySelector('.alert-clean');
                    if (alert) {
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 300);
                    }
                }, 5000);

                // Search functionality
                const searchInput = document.querySelector('.search-input');
                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        const searchTerm = this.value.toLowerCase();
                        const rows = document.querySelectorAll('tbody tr');

                        rows.forEach(row => {
                            const text = row.textContent.toLowerCase();
                            row.style.display = text.includes(searchTerm) ? '' : 'none';
                        });
                    });
                }
            });

            // Selection functionality
            function toggleSelectAll(checkbox) {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]');
                checkboxes.forEach(item => {
                    item.checked = checkbox.checked;
                    item.closest('tr').classList.toggle('selected', checkbox.checked);
                });
                updateSelectionCount();
            }

            function updateSelectionCount() {
                const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
                const count = selectedCheckboxes.length;
                const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

                document.getElementById('selection-count').textContent = count;
                document.getElementById('total-count').textContent = totalCount;

                const selectedIds = Array.from(selectedCheckboxes).map(input => input.value);
                document.getElementById('selectedIds').value = selectedIds.join(',');

                // Enable/disable move to archive button
                const moveToArchiveBtn = document.getElementById('moveToArchiveBtn');
                moveToArchiveBtn.disabled = count === 0;
                moveToArchiveBtn.style.opacity = count === 0 ? '0.5' : '1';

                // Update select all checkbox
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = count === totalCount && totalCount > 0;
                selectAllCheckbox.indeterminate = count > 0 && count < totalCount;
            }

            // "All" link functionality
            document.getElementById('select-all-link').addEventListener('click', function (e) {
                e.preventDefault();
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
                toggleSelectAll(selectAllCheckbox);
            });


        </script>
    </body>

@endsection