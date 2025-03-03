<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Workout Program Default List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
                <h1>Workout Program Default List</h1>
                <!-- Button to trigger modal -->
                <div>
                    <div class="d-flex justify-content-end position-relative">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addWorkoutProgramModal"><i class="fa fa-plus mx-1" aria-hidden="true"></i>
                            Add New Workout Program
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
                    <a href="#">Trashed (0)</a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-light border mx-2" style="height: 35px;"
                            onclick="return confirm('Are you sure you want to delete all this equipment?')"><i
                                class="fa fa-trash"></i> Move to Trash</button>
                        <form class="d-flex" role="search">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                style="height: 35px;">
                            <button class="btn btn-primary ms-2" type="submit" style="height: 35px;">Search</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                            <th class="text-center">ID</th>
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
                        @foreach($workoutPrograms as $workoutProgram)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $workoutProgram->id }}" />
                                </td>
                                <td class="text-center">
                                    {{ ($workoutPrograms->currentPage() - 1) * $workoutPrograms->perPage() + $loop->index + 1 }}
                                </td>
                                <td class="text-center">{{ $workoutProgram->category }}</td>
                                <td class="text-center">{{ $workoutProgram->type }}</td>
                                <td class="text-center">{{ $workoutProgram->guideline }}</td>
                                <td class="text-center">{{ $workoutProgram->day }}</td>
                                <td class="text-center">{{ $workoutProgram->workout }}</td>
                                <td class="text-center">{{ $workoutProgram->difficulty }}</td>
                                <td class="text-center">{{ $workoutProgram->duration }}</td>
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editWorkoutProgramModal{{ $workoutProgram->id }}">Update</button>

                                    <!-- Delete Button (Form for DELETE request) -->
                                    <form action="{{ route('workout-programs.destroy', $workoutProgram->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this workout program?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4 mb-4">
                        <li class="page-item {{ $workoutPrograms->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $workoutPrograms->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $workoutPrograms->lastPage()) as $page)
                            <li class="page-item {{ $page == $workoutPrograms->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $workoutPrograms->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$workoutPrograms->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $workoutPrograms->nextPageUrl() }}">Next</a>
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
                        <form action="{{ route('workout-programs.store') }}" method="POST">
                            @csrf

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
                                                    placeholder="Guideline">
                                            </div>
                                            <div class="mb-3">
                                                <label for="day" class="form-label">Day</label>
                                                <select class="form-control" id="day" name="day">
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
                                                <input type="text" class="form-control" id="workout" name="workout"
                                                    placeholder="Workout">
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
                                                    placeholder="E.g., Beginner, Intermediate, Advanced">
                                            </div>
                                            <div class="mb-3">
                                                <label for="duration" class="form-label">Duration</label>
                                                <input type="text" class="form-control" id="duration" name="duration"
                                                    placeholder="E.g., 30 minutes">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Buttons -->
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Workout Program</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Workout Program -->
        @foreach($workoutPrograms as $workoutProgram)
            <div class="modal fade" id="editWorkoutProgramModal{{ $workoutProgram->id }}" tabindex="-1"
                aria-labelledby="editWorkoutProgramModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editWorkoutProgramModalLabel">Edit Workout Program</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('workout-programs.update', $workoutProgram->id) }}" method="POST">
                                @csrf
                                @method('PUT')

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
                                    <label for="type{{ $workoutProgram->id }}" class="form-label">Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="">Select Type</option>
                                        @foreach($workoutTypes as $type)
                                            <option value="{{ $type }}" {{ $workoutProgram->type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Accordion for Details -->
                                <div class="accordion" id="editWorkoutProgramAccordion{{ $workoutProgram->id }}">
                                    <!-- General Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingDetails{{ $workoutProgram->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseDetails{{ $workoutProgram->id }}"
                                                aria-expanded="true"
                                                aria-controls="editCollapseDetails{{ $workoutProgram->id }}">
                                                General Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseDetails{{ $workoutProgram->id }}"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="editHeadingDetails{{ $workoutProgram->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="guideline{{ $workoutProgram->id }}"
                                                        class="form-label">Guideline</label>
                                                    <input type="text" class="form-control"
                                                        id="guideline{{ $workoutProgram->id }}" name="guideline"
                                                        value="{{ $workoutProgram->guideline }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="day{{ $workoutProgram->id }}" class="form-label">Day</label>
                                                    <select class="form-control" id="day{{ $workoutProgram->id }}" name="day">
                                                        @php
                                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                                        @endphp
                                                        @foreach($days as $day)
                                                            <option value="{{ $day }}" {{ $workoutProgram->day == $day ? 'selected' : '' }}>{{ $day }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="workout{{ $workoutProgram->id }}"
                                                        class="form-label">Workout</label>
                                                    <input type="text" class="form-control"
                                                        id="workout{{ $workoutProgram->id }}" name="workout"
                                                        value="{{ $workoutProgram->workout }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Workout Program Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingWorkouts{{ $workoutProgram->id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseWorkouts{{ $workoutProgram->id }}"
                                                aria-expanded="false"
                                                aria-controls="editCollapseWorkouts{{ $workoutProgram->id }}">
                                                Workout Program Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseWorkouts{{ $workoutProgram->id }}"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="editHeadingWorkouts{{ $workoutProgram->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="difficulty{{ $workoutProgram->id }}"
                                                        class="form-label">Difficulty</label>
                                                    <input type="text" class="form-control"
                                                        id="difficulty{{ $workoutProgram->id }}" name="difficulty"
                                                        value="{{ $workoutProgram->difficulty }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="duration{{ $workoutProgram->id }}"
                                                        class="form-label">Duration</label>
                                                    <input type="text" class="form-control"
                                                        id="duration{{ $workoutProgram->id }}" name="duration"
                                                        value="{{ $workoutProgram->duration }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Buttons Section -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Workout Program</button>
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