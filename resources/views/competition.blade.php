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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <title>Competition Form Records</title>
    <style>
        /* Minimalist Global Styles */
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

        /* Minimalist Card Styles */
        .content-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            padding: 40px;
            margin-bottom: 32px;
            border: 1px solid #e1e5e9;
        }

        /* Minimalist Header */
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

        /* Minimalist Table Styles */
        .table-section h2 {
            font-size: 20px;
            font-weight: 500;
            color: #333;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e1e5e9;
        }

        /* Table Container - Prevent Horizontal Scroll */
        .table-container {
            overflow-x: auto;
            border: 1px solid #e1e5e9;
            border-radius: 4px;
            max-width: 100%;
        }

        /* Table Layout - Optimize Column Widths */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            table-layout: fixed;
        }

        th, td {
            padding: 12px 8px;
            text-align: left;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Column Widths */
        th:first-child, td:first-child { width: 50px; }  /* Checkbox */
        th:nth-child(2), td:nth-child(2) { width: 60px; }  /* ID */
        th:nth-child(3), td:nth-child(3) { width: 150px; } /* Name */
        th:nth-child(4), td:nth-child(4) { width: 60px; }  /* Age */
        th:nth-child(5), td:nth-child(5) { width: 80px; }  /* Gender */
        th:nth-child(6), td:nth-child(6) { width: 100px; } /* Height */
        th:nth-child(7), td:nth-child(7) { width: 100px; } /* Weight */
        th:nth-child(8), td:nth-child(8) { width: 140px; } /* Competition Type */
        th:nth-child(9), td:nth-child(9) { width: 200px; } /* Actions */

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

        .filter-links a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .filter-links a:hover {
            background: #e3f2fd;
        }

        .filter-links a.active {
            background: #007bff;
            color: white;
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
            table-layout: fixed;
        }

        th {
            background: #f8f9fa;
            color: #333;
            font-weight: 500;
            padding: 16px 12px;
            text-align: center !important;
            border-bottom: 1px solid #e1e5e9;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            min-width: 100px;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            text-align: center !important;
            vertical-align: middle;
            min-width: 100px;
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

        /* Checkbox column alignment */
        th:first-child,
        td:first-child {
            text-align: center;
            width: 50px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
            min-width: 200px;
        }

        /* Minimalist Button Styles */
        .btn {
            border-radius: 4px;
            padding: 10px 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background: #0056b3;
            border-color: #0056b3;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
            border-color: #c82333;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 13px;
            min-width: 80px;
        }

        /* Minimalist Pagination */
        .pagination {
            margin-top: 24px;
            justify-content: center;
        }

        .page-link {
            border: 1px solid #e1e5e9;
            color: #007bff;
            padding: 8px 12px;
            margin: 0 2px;
            border-radius: 4px;
            font-size: 14px;
        }

        .page-link:hover {
            background: #f8f9fa;
            border-color: #007bff;
        }

        .page-item.active .page-link {
            background: #007bff;
            border-color: #007bff;
            color: white;
        }

        .page-item.disabled .page-link {
            color: #6c757d;
            background: #f8f9fa;
            border-color: #e1e5e9;
        }

        /* Minimalist Modal */
        .modal-content {
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e1e5e9;
            border-radius: 8px 8px 0 0;
        }

        .modal-title {
            font-weight: 500;
            color: #333;
        }

        /* Minimalist Alert */
        .custom-alert-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
            font-size: 14px;
            margin-bottom: 16px;
        }

        /* Badge */
        .badge {
            background: #e9ecef;
            color: #495057;
            font-weight: 500;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge.bg-primary {
            background: #007bff !important;
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 48px 24px;
            color: #666;
        }

        .empty-state i {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 16px;
        }

        .empty-state h5 {
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 8px;
            color: #333;
        }

        .empty-state p {
            font-size: 14px;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .table-container {
                overflow-x: auto;
            }
            
            table {
                table-layout: auto;
                min-width: 900px;
            }
        }

        @media (max-width: 768px) {
            .main-wrapper {
                padding: 20px 16px;
            }

            .content-card {
                padding: 24px 16px;
            }

            .filter-options {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .filter-links {
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
                gap: 6px;
                min-width: auto;
            }
            
            .btn-sm {
                min-width: 100px;
            }
        }

        /* Fade animations */
        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Text utilities */
        .text-muted {
            color: #6c757d !important;
        }

        .text-center {
            text-align: center !important;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Gym Competition Records</h1>
                <p>Manage and track competition participant information</p>
            </div>

            <!-- Competition Records Section -->
            <div class="content-card">
                <div class="table-section">
                    <h2>All Competition Records</h2>

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

                    <div class="filter-options">
                        <div class="filter-links">
                            <a href="{{ route('competitions.index') }}" id="select-all-link" class="active">
                                All ({{ App\Models\Competition::count() }})
                            </a>
                            <a href="{{ route('competitions.trashed') }}">
                                Archived ({{ App\Models\Competition::onlyTrashed()->count() }})
                            </a>
                        </div>

                        <div>
                            <form action="{{ route('competitions.moveToTrash') }}" method="POST" class="d-inline"
                                id="move-to-archive-form">
                                @csrf
                                <input type="hidden" name="selected" id="selectedIds">
                                <button type="submit" class="btn btn-light border mx-2" id="moveToArchiveBtn" disabled>
                                    <i class="fa fa-trash"></i> Move to Archive
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Table section -->
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Height (cm)</th>
                                    <th>Weight (kg)</th>
                                    <th>Type of Competition</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($competitions as $competition)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $competition->id }}"
                                                onchange="updateSelectionCount()" />
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $competition->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $competition->name }}</strong>
                                        </td>
                                        <td class="text-center">{{ $competition->age }}</td>
                                        <td class="text-center">{{ $competition->gender }}</td>
                                        <td class="text-center">{{ $competition->height }}</td>
                                        <td class="text-center">{{ $competition->weight }}</td>
                                        <td>{{ $competition->type_of_competition }}</td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-outline-primary me-2 edit-btn" data-bs-toggle="modal"
                                                    data-bs-target="#editCompetitionModal" data-id="{{ $competition->id }}"
                                                    data-name="{{ $competition->name }}" data-age="{{ $competition->age }}"
                                                    data-gender="{{ $competition->gender }}"
                                                    data-height="{{ $competition->height }}"
                                                    data-weight="{{ $competition->weight }}"
                                                    data-activity="{{ $competition->type_of_competition }}">
                                                    <i class="fa fa-pencil mr-1"></i>
                                                    Update
                                                </button>
                                                <form action="{{ route('competitions.destroy', $competition->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this competition record?')">
                                                        <i class="fa fa-trash mr-1"></i>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9">
                                            <div class="empty-state">
                                                <i class="fa fa-trophy"></i>
                                                <h5>No competition records found</h5>
                                                <p>Add your first competition participant to get started</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center mt-4 mb-4">
                                <li class="page-item {{ $competitions->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $competitions->previousPageUrl() }}" tabindex="-1">Previous</a>
                                </li>

                                @foreach(range(1, $competitions->lastPage()) as $page)
                                    <li class="page-item {{ $page == $competitions->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $competitions->url($page) }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <li class="page-item {{ !$competitions->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $competitions->nextPageUrl() }}">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Competition Modal -->
        <div class="modal fade" id="editCompetitionModal" tabindex="-1" aria-labelledby="editCompetitionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="editCompetitionForm" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Competition Record</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="competition_id" id="competition_id">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" id="edit_age" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <input type="text" name="gender" id="edit_gender" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Height (cm)</label>
                                <input type="number" name="height" id="edit_height" class="form-control" step="0.01">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Weight (kg)</label>
                                <input type="text" name="weight" id="edit_weight" class="form-control" step="0.01">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type of Competition</label>
                                <select name="type_of_competition" id="edit_competition" class="form-control">
                                    <option value="" disabled selected>-- Select Competition Type --</option>
                                    <option value="Powerlifting">Powerlifting</option>
                                    <option value="Boxing">Boxing</option>
                                    <option value="Crossfit">Crossfit</option>
                                    <option value="Body building">Body building</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update Record</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

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

            // Edit modal functionality
            const editModal = document.getElementById('editCompetitionModal');
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const age = button.getAttribute('data-age');
                const gender = button.getAttribute('data-gender');
                const height = button.getAttribute('data-height');
                const weight = button.getAttribute('data-weight');
                const activity = button.getAttribute('data-activity');

                document.getElementById('competition_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_age').value = age;
                document.getElementById('edit_gender').value = gender;
                document.getElementById('edit_height').value = height;
                document.getElementById('edit_weight').value = weight;

                const activitySelect = document.getElementById('edit_competition');
                if (activitySelect) {
                    [...activitySelect.options].forEach(option => {
                        option.selected = option.value === activity;
                    });
                }

                const form = document.getElementById('editCompetitionForm');
                form.action = `/competitions/${id}`;
            });

            // Prevent form submission if no competitions are selected
            document.getElementById('move-to-archive-form').addEventListener('submit', function (e) {
                const selectedIds = document.getElementById('selectedIds').value;
                if (!selectedIds) {
                    alert('Please select at least one competition to move to archive.');
                    e.preventDefault(); // Prevent form submission
                }
            });

            // Initialize selection count on page load
            document.addEventListener("DOMContentLoaded", function () {
                updateSelectionCount();
            });
        </script>

    </body>

    </html>
@endsection