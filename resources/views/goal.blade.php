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

    <title>Goal Records</title>
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
            margin-bottom: 32px;
        }

        .header-section h1 {
            font-size: 28px;
            font-weight: 400;
            color: #333;
            margin: 0;
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
            white-space: nowrap;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        /* Minimalist Checkbox */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #007bff;
            margin: 0;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
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

        /* Custom Alert Message */
        .custom-alert-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            margin-bottom: 24px;
            transition: opacity 0.3s ease;
        }

        .custom-alert-message.fade-out {
            opacity: 0;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Goal Records</h1>
                <p>Track member fitness goals and progress monitoring</p>
            </div>

            <!-- Goal Records Section -->
            <div class="content-card">
                <div class="header-section">
                    <div class="d-flex align-items-center gap-3 mb-2" style="justify-content: space-between;">
                        <div>
                            <h1 class="card-title mb-0" style="font-size: 20px; font-weight: 500; color: #333;">Goal For Mobile Information</h1>
                            <p class="text-muted mb-0">Monitor member fitness goals and progress tracking</p>
                        </div>
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

            <div class="filter-options">
                <div class="filter-links">
                    <!-- Link to view all -->
                    <a href="{{ route('goals.index') }}" class="btn-style" id="select-all-link">All
                        ({{ App\Models\Goal::count() }})</a>

                    <!-- Link to view archived goals -->
                    <a href="{{ route('goals.trashed') }}">Archived ({{ App\Models\Goal::onlyTrashed()->count() }})</a>

                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <form action="{{ route('goals.moveToTrash') }}" method="POST" id="move-to-archive-form">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2" id="moveToArchiveBtn" disabled>
                                <i class="fa fa-trash"></i> Move to Archive
                            </button>
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
                            <th class="text-center">Status</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Starting Weight (Kg)</th>
                            <th class="text-center">Starting Date</th>
                            <th class="text-center">Current Weight (Kg)</th>
                            <th class="text-center">Goal Weight (Kg)</th>
                            <th class="text-center">Weekly Goal (Kg)</th>
                            <th class="text-center">Activity</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($goals as $index => $goal)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $goal->id }}"
                                        onchange="updateSelectionCount()" /></td>
                                <td class="text-center">{{ $goal->id }}</td>
                                <td class="text-center">{{ $goal->status}}</td>
                                <td class="text-center">{{ $goal->name }}</td>
                                <td class="text-center">{{ $goal->starting_weight }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($goal->starting_date)->format('m/d/Y') }}</td>
                                <td class="text-center">{{ $goal->current_weight }}</td>
                                <td class="text-center">{{ $goal->goal_weight }}</td>
                                <td class="text-center">{{ $goal->weekly_goal }}</td>
                                <td class="text-center">{{ $goal->activity }}</td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal"
                                        data-bs-target="#editGoalModal" data-id="{{ $goal->id }}" data-name="{{ $goal->name }}"
                                        data-starting_weight="{{ $goal->starting_weight }}"
                                        data-starting_date="{{ $goal->starting_date }}"
                                        data-current_weight="{{ $goal->current_weight }}"
                                        data-goal_weight="{{ $goal->goal_weight }}" data-weekly_goal="{{ $goal->weekly_goal }}"
                                        data-activity="{{ $goal->activity }}" data-status="{{ $goal->status }}">
                                        <i class="fa fa-pencil mr-1"></i>
                                        Update
                                    </button>

                                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this goal information?')">
                                            <i class="fa fa-trash mr-1"></i>
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination links -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4 mb-4">
                        <li class="page-item {{ $goals->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $goals->previousPageUrl() }}">Previous</a>
                        </li>

                        @foreach ($goals->getUrlRange(1, $goals->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $goals->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$goals->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $goals->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Edit Goal Modal -->
        <div class="modal fade" id="editGoalModal" tabindex="-1" aria-labelledby="editGoalModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="editGoalForm" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Goal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="goal_id" id="goal_id">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Starting Weight</label>
                                <input type="number" name="starting_weight" id="edit_starting_weight" class="form-control"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label>Starting date</label>
                                <input type="date" name="starting_date" id="edit_starting_date" class="form-control"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label>Current Weight</label>
                                <input type="number" name="current_weight" id="edit_current_weight" class="form-control"
                                    step="0.01" min="0">
                            </div>
                            <div class="mb-3">
                                <label>Goal Weight</label>
                                <input type="number" name="goal_weight" id="edit_goal_weight" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Weekly Goal</label>
                                <input type="text" name="weekly_goal" id="edit_weekly_goal" class="form-control" readonly>
                            </div>
                            <div class="mb-3">
                                <label>Activity Level</label>
                                <select name="activity" id="edit_activity" class="form-control">
                                    <option value="" disabled selected>-- Select Activity Level --</option>
                                    <option value="Not Very Active">Not Very Active</option>
                                    <option value="Lightly Active">Lightly Active</option>
                                    <option value="Active">Active</option>
                                    <option value="Very Active">Very Active</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update Goal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <script>
            const editModal = document.getElementById('editGoalModal');
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                // Get data from button
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const startingWeight = button.getAttribute('data-starting_weight');
                const startingDate = button.getAttribute('data-starting_date');
                const currentWeight = button.getAttribute('data-current_weight');
                const goalWeight = button.getAttribute('data-goal_weight');
                const weeklyGoal = button.getAttribute('data-weekly_goal');
                const activity = button.getAttribute('data-activity');
                const status = button.getAttribute('data-status');

                // Fill modal fields
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_starting_weight').value = startingWeight;
                document.getElementById('edit_starting_date').value = startingDate
                document.getElementById('edit_current_weight').value = currentWeight;
                document.getElementById('edit_goal_weight').value = goalWeight;
                document.getElementById('edit_weekly_goal').value = weeklyGoal;

                // Set selected activity
                const activitySelect = document.getElementById('edit_activity');
                if (activitySelect) {
                    [...activitySelect.options].forEach(option => {
                        option.selected = option.value === activity;
                    });
                }

                // Set form action to /goals/{id}
                const form = document.getElementById('editGoalForm');
                form.action = `{{ url('/goals') }}/${id}`;
            });


            // Select all checkboxes
            function toggleSelectAll(source) {
                const checkboxes = document.getElementsByName('selected[]');
                for (let i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = source.checked;
                }
                updateSelectionCount();
            }

            // Update the selection count
            function updateSelectionCount() {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
                const count = checkboxes.length;
                const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

                document.getElementById('select-all-link').textContent = `All (${count}/${totalCount})`;

                // Enable/disable move to archive button
                const moveToArchiveBtn = document.getElementById('moveToArchiveBtn');
                if (moveToArchiveBtn) {
                    moveToArchiveBtn.disabled = count === 0;
                }

                // Update select all checkbox
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = count === totalCount && totalCount > 0;
                    selectAllCheckbox.indeterminate = count > 0 && count < totalCount;
                }

                // Update hidden input with selected IDs
                const selectedIds = Array.from(checkboxes).map(input => input.value);
                document.getElementById('selectedIds').value = selectedIds.join(',');
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

            // Prevent form submission if no goals are selected
            document.getElementById('move-to-archive-form').addEventListener('submit', function (e) {
                const selectedIds = document.getElementById('selectedIds').value;
                if (!selectedIds) {
                    alert('Please select at least one goal to move to archive.');
                    e.preventDefault(); // Prevent form submission
                }
            });
        </script>
            </div>
        </div>

    </body>

    </html>
@endsection