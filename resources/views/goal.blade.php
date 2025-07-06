<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <title>Goal Records</title>
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
            background-color: #f8f9fc;
            /* Light background */
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
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
            background-color: transparent;
        }

        th {
            font-weight: bold;
            border-bottom: 1px solid #999;
            padding: 12px 10px;
            text-align: center;
            background-color: transparent !important;
            white-space: nowrap;
        }

        .nowrap {
            white-space: nowrap;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
        }

        input[type="checkbox"] {
            margin: 0;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Goal For Mobile Information</h1>
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
                    <a href="#" id="select-all-link">All (0)</a>

                    <!-- Link to view all trashed announcements -->
                    <a href="#" id="select-all-link">Archived (0)</a>

                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <form action="#" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2">
                                <i class="fa fa-trash"></i> Move to Trash
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
                                <td class="text-center">{{ $goal->current_weight }}</td>
                                <td class="text-center">{{ $goal->goal_weight }}</td>
                                <td class="text-center">{{ $goal->weekly_goal }}</td>
                                <td class="text-center">{{ $goal->activity }}</td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editGoalModal"
                                        data-id="{{ $goal->id }}" data-name="{{ $goal->name }}"
                                        data-starting_weight="{{ $goal->starting_weight }}"
                                        data-current_weight="{{ $goal->current_weight }}"
                                        data-goal_weight="{{ $goal->goal_weight }}" data-weekly_goal="{{ $goal->weekly_goal }}"
                                        data-activity="{{ $goal->activity }}" data-status="{{ $goal->status }}">
                                        <i class="fa fa-pencil-square-o mx-1"></i>Update
                                    </button>

                                    <form action="{{ route('goals.destroy', $goal->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-1"
                                            onclick="return confirm('Are you sure you want to delete this goal information?')">
                                            <i class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination links -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4">
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
                                <label>Current Weight</label>
                                <input type="number" name="current_weight" id="edit_current_weight" class="form-control">
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
                                    <option value="Light Active">Light Active</option>
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
                const currentWeight = button.getAttribute('data-current_weight');
                const goalWeight = button.getAttribute('data-goal_weight');
                const weeklyGoal = button.getAttribute('data-weekly_goal');
                const activity = button.getAttribute('data-activity');
                const status = button.getAttribute('data-status');

                // Fill modal fields
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_starting_weight').value = startingWeight;
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
                document.getElementById('select-all-link').innerText = `All (${count})`;
            }
        </script>

    </body>

    </html>
@endsection