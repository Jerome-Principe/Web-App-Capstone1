<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Workout Program Custom List</title>
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
            max-height: 700px;
            overflow-y: auto;
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
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
        }

        /* Hover effect */
        tbody tr:hover {
            background-color: #eaeaea;
            cursor: pointer;
        }

        input[type="checkbox"] {
            margin: 0;
        }

        .date-info {
            font-size: 12px;
            color: gray;
        }

        .modal {
            z-index: 1055;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Workout Program Custom List</h1>
                <!-- Button to trigger modal -->
                <div>
                    <div class="d-flex justify-content-end position-relative">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addWorkoutProgramModal"><i class="fa fa-plus mx-1" aria-hidden="true"></i>
                            Add New Workout Program Custom
                        </button>
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
                    <a href="#" id="select-all-link">All (0)</a>
                    <a href="#">Archived (0)</a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-light border mx-2" style="height: 35px;"
                            onclick="return confirm('Are you sure you want to move all these workout programs to the archive?')"><i
                                class="fa fa-trash"></i> Move to Archive</button>
                        <form class="d-flex" role="search">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                style="height: 35px;">
                            <button class="btn btn-primary ms-2" type="submit" style="height: 35px;">Search</button>
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
                            <th class="text-center">User Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Guideline</th>
                            <th class="text-center">Day</th>
                            <th class="text-center">Workout</th>
                            <th class="text-center">Difficulty</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($workoutProgramsCustom as $workoutProgramCustom)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $workoutProgramCustom->id }}" />
                                </td>
                                <td class="text-center">{{ $workoutProgramCustom->id }}</td>
                                <td class="text-center">{{ $workoutProgramCustom->user->name ?? 'User Not Found' }}</td>
                                <td class="text-center">{{ $workoutProgramCustom->category }}</td>
                                <td class="text-center">{{ $workoutProgramCustom->type }}</td>
                                <td class="text-center">{{ $workoutProgramCustom->guideline }}</td>
                                <td class="text-center">{{ $workoutProgramCustom->day }}</td>
                                <td class="text-center">{{ $workoutProgramCustom->workout }}</td>
                                <td class="text-center">{{ $workoutProgramCustom->difficulty }}</td>
                                <td class="text-center">{{ $workoutProgramCustom->duration }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                            data-bs-target="#editWorkoutProgramModal{{ $workoutProgramCustom->id }}">
                                            <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                        </button>

                                        <!-- Delete Button (Form for DELETE request) -->
                                        <form action="{{ route('workout-program-custom.destroy', $workoutProgramCustom->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this workout program?')">
                                                <i class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4 mb-4">
                        <li class="page-item {{ $workoutProgramsCustom->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $workoutProgramsCustom->previousPageUrl() }}"
                                tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $workoutProgramsCustom->lastPage()) as $page)
                            <li class="page-item {{ $page == $workoutProgramsCustom->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $workoutProgramsCustom->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$workoutProgramsCustom->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $workoutProgramsCustom->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal for Adding Workout Program -->
        <div class="modal fade" id="addWorkoutProgramModal" tabindex="-1" aria-labelledby="addWorkoutProgramModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addWorkoutProgramModalLabel">Add New Workout Program</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('workout-program-custom.store') }}" method="POST">
                            @csrf

                            <!-- User Details Section -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User Name</label>
                                <select class="form-control" name="user_id" id="user_id">
                                    <option value="">Select User</option>
                                    @foreach($approvedUsers as $userId => $userName)
                                        <option value="{{ $userId }}" {{ old('user_id') == $userId ? 'selected' : '' }}>
                                            {{ $userName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control" id="category" name="category"
                                    value="Workout Program" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Advanced Lifting Program">Advanced Lifting Program</option>
                                    <option value="Beginner Full-Body Workout">Beginner Full-Body Workout</option>
                                    <option value="3-Day PPL Beginner Workout">3-Day PPL Beginner Workout</option>
                                    <option value="4-Day Dumbbell Upper/Lower Routine">4-Day Dumbbell Upper/Lower Routine
                                    </option>
                                    <option value="6-Day PPL Powerbuilding Plan">6-Day PPL Powerbuilding Plan</option>
                                    <option value="8-Week Muscle Growth Plan">8-Week Muscle Growth Plan</option>
                                    <option value="8-Week Beginner Fat Loss Plan">8-Week Beginner Fat Loss Plan</option>
                                    <option value="8-Week Advanced Strength Building Workout">8 Week Advanced Strength
                                        Building Workout
                                    </option>
                                </select>
                            </div>

                            <!-- Collapsible Section for Details -->
                            <div class="accordion" id="workoutProgramAccordion">
                                <!-- General Details -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingDetails">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseDetails" aria-expanded="true"
                                            aria-controls="collapseDetails">
                                            General Details
                                        </button>
                                    </h2>
                                    <div id="collapseDetails" class="accordion-collapse collapse show"
                                        aria-labelledby="headingDetails">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label for="guideline" class="form-label">Guideline</label>
                                                <input type="text" class="form-control" id="guideline" name="guideline"
                                                    placeholder="Guideline" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="day" class="form-label">Day</label>
                                                <select class="form-control" id="day" name="day" required>
                                                    <option value="">Select Day</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="workout" class="form-label">Workout</label>
                                                <textarea type="text" class="form-control" id="workout" name="workout"
                                                    placeholder="Workout" required
                                                    style="height: 100px; resize: none; white-space: pre-wrap;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Workout Program Details -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingWorkouts">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseWorkouts" aria-expanded="false"
                                            aria-controls="collapseWorkouts">
                                            Workout Program Details
                                        </button>
                                    </h2>
                                    <div id="collapseWorkouts" class="accordion-collapse collapse"
                                        aria-labelledby="headingWorkouts">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label for="difficulty" class="form-label">Difficulty</label>
                                                <input type="text" class="form-control" id="difficulty" name="difficulty"
                                                    placeholder="E.g., Beginner, Intermediate, Advanced" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="duration" class="form-label">Duration</label>
                                                <input type="text" class="form-control" id="duration" name="duration"
                                                    placeholder="E.g., 30 minutes" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Buttons -->
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Workout Program Custom</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Workout Program -->
        @foreach($workoutProgramsCustom as $workoutProgramCustom)
            <div class="modal fade" id="editWorkoutProgramModal{{ $workoutProgramCustom->id }}" tabindex="-1"
                aria-labelledby="editWorkoutProgramModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editWorkoutProgramModalLabel">Edit Workout Program Custom</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('workout-program-custom.update', $workoutProgramCustom->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <!-- User Details Section -->
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">User Name</label>
                                    <select class="form-control" name="user_id" id="user_id">
                                        <option value="">Select User</option>
                                        @foreach($approvedUsers as $userId => $userName)
                                            <option value="{{ $userId }}" {{ old('user_id', $workoutProgramCustom->user_id) == $userId ? 'selected' : '' }}>
                                                {{ $userName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Category and Type Section -->
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category" name="category"
                                        value="Workout Program" readonly>
                                </div>

                                @php
                                    $workoutTypes = [
                                        'Advanced Lifting Program',
                                        'Beginner Full-Body Workout',
                                        '3-Day PPL Beginner Workout',
                                        '4-Day Dumbbell Upper/Lower Routine',
                                        '6-Day PPL Powerbuilding Split',
                                        '8-Week Advanced Strength Building Workout',
                                        '8-Week Muscle Growth Plan',
                                        '8-Week Beginner Fat Loss Plan'
                                    ];
                                @endphp

                                <div class="mb-3">
                                    <label for="type{{ $workoutProgramCustom->id }}" class="form-label">Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="">Select Type</option>
                                        @foreach($workoutTypes as $type)
                                            <option value="{{ $type }}" {{ $workoutProgramCustom->type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Accordion for Details -->
                                <div class="accordion" id="editWorkoutProgramAccordion{{ $workoutProgramCustom->id }}">
                                    <!-- General Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingDetails{{ $workoutProgramCustom->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseDetails{{ $workoutProgramCustom->id }}"
                                                aria-expanded="true"
                                                aria-controls="editCollapseDetails{{ $workoutProgramCustom->id }}">
                                                General Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseDetails{{ $workoutProgramCustom->id }}"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="editHeadingDetails{{ $workoutProgramCustom->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="guideline{{ $workoutProgramCustom->id }}"
                                                        class="form-label">Guideline</label>
                                                    <input type="text" class="form-control"
                                                        id="guideline{{ $workoutProgramCustom->id }}" name="guideline"
                                                        value="{{ $workoutProgramCustom->guideline }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="day{{ $workoutProgramCustom->id }}"
                                                        class="form-label">Day</label>
                                                    <select class="form-control" id="day{{ $workoutProgramCustom->id }}"
                                                        name="day">
                                                        @php
                                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                        @endphp
                                                        @foreach($days as $day)
                                                            <option value="{{ $day }}" {{ $workoutProgramCustom->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="workout{{ $workoutProgramCustom->id }}"
                                                        class="form-label">Workout</label>
                                                    <textarea class="form-control" id="workout{{ $workoutProgramCustom->id }}"
                                                        name="workout"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $workoutProgramCustom->workout }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Workout Program Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingWorkouts{{ $workoutProgramCustom->id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseWorkouts{{ $workoutProgramCustom->id }}"
                                                aria-expanded="false"
                                                aria-controls="editCollapseWorkouts{{ $workoutProgramCustom->id }}">
                                                Workout Program Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseWorkouts{{ $workoutProgramCustom->id }}"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="editHeadingWorkouts{{ $workoutProgramCustom->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="difficulty{{ $workoutProgramCustom->id }}"
                                                        class="form-label">Difficulty</label>
                                                    <input type="text" class="form-control"
                                                        id="difficulty{{ $workoutProgramCustom->id }}" name="difficulty"
                                                        value="{{ $workoutProgramCustom->difficulty }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="duration{{ $workoutProgramCustom->id }}"
                                                        class="form-label">Duration</label>
                                                    <input type="text" class="form-control"
                                                        id="duration{{ $workoutProgramCustom->id }}" name="duration"
                                                        value="{{ $workoutProgramCustom->duration }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Buttons Section -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Workout Program Custom</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </body>

    <script>
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateSelectionCount();
        }

        function updateSelectionCount() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const count = checkboxes.length;
            document.getElementById('select-all-link').innerText = `All (${count})`;
        }
    </script>

@endsection