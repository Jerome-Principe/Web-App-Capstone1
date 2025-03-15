<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Exercise Default List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
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

        .table-container {
            max-height: 700px;
            overflow-y: auto;
            overflow-x: auto;
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
                <h1>Exercise Custom List</h1>
                <!-- Button to trigger modal -->
                <div>
                    <div class="d-flex justify-content-end position-relative">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addExerciseModal"><i class="fa fa-plus mx-1" aria-hidden="true"></i>
                            Add New Exercise
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
                            onclick="return confirm('Are you sure you want to move all these exercises to the archive?')"><i
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
                            <th class="text-center">Exercises</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exercisesCustom as $exerciseCustom)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $exerciseCustom->id }}" />
                                </td>
                                <td class="text-center">{{ $exerciseCustom->id }}</td>
                                <td class="text-center">{{ $exerciseCustom->user->name ?? 'User Not Found' }}</td>
                                <td class="text-center">{{ $exerciseCustom->category }}</td>
                                <td class="text-center">{{ $exerciseCustom->type }}</td>
                                <td class="text-center">{{ $exerciseCustom->guideline }}</td>
                                <td class="text-center">{{ $exerciseCustom->exercise }}</td>
                                <td class="text-center">{{ $exerciseCustom->description }}</td>
                                <td class="text-center">{{ $exerciseCustom->duration }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                            data-bs-target="#editExerciseModal{{ $exerciseCustom->id }}">
                                            <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                        </button>

                                        <!-- Delete Button (Form for DELETE request) -->
                                        <form action="{{ route('exercise-custom.destroy', $exerciseCustom->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this exercise?')">
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
                        <li class="page-item {{ $exercisesCustom->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $exercisesCustom->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $exercisesCustom->lastPage()) as $page)
                            <li class="page-item {{ $page == $exercisesCustom->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $exercisesCustom->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$exercisesCustom->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $exercisesCustom->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>

        <!-- Modal for Adding Exercise Program -->
        <div class="modal fade" id="addExerciseModal" tabindex="-1" aria-labelledby="addExerciseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExerciseModalLabel">Add New Exercise</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('exercise-custom.store') }}" method="POST">
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
                                <input type="text" class="form-control" id="category" name="category" value="Exercise"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required onchange="updateExercise()">
                                    <option value="">Select Type</option>
                                    <option value="Strength Training">Strength Training</option>
                                    <option value="Cardiovascular exercises">Cardiovascular exercises</option>
                                    <option value="Plyometrics">Plyometrics</option>
                                    <option value="Core Strength exercises">Core Strength exercises
                                    </option>
                                </select>
                            </div>

                            <!-- Collapsible Section for Details -->
                            <div class="accordion" id="exerciseAccordion">
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
                                                <textarea type="text" class="form-control" id="guideline" name="guideline"
                                                    placeholder="Guideline" required
                                                    style="height: 100px; resize: none; white-space: pre-wrap;"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="exercise" class="form-label">Exercises</label>
                                                <select class="form-control" id="exercise" name="exercise" required>
                                                    <option value="">Select Exercise</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea type="text" class="form-control" id="description"
                                                    name="description" placeholder="Exercise" required
                                                    style="height: 100px; resize: none; white-space: pre-wrap;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Exercise Details -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingExercise">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseExercise" aria-expanded="false"
                                            aria-controls="collapseExercise">
                                            Exercise Details
                                        </button>
                                    </h2>
                                    <div id="collapseExercise" class="accordion-collapse collapse"
                                        aria-labelledby="headingExercise">
                                        <div class="accordion-body">
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
                                <button type="submit" class="btn btn-primary">Add Exercise</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript to Update Exercise Dropdown -->
        <script>
            function updateExercise() {
                const type = document.getElementById('type').value;
                const exerciseSelect = document.getElementById('exercise');

                // Clear previous options
                exerciseSelect.innerHTML = '<option value="">Select Exercise</option>';

                let exercises = [];

                switch (type) {
                    case 'Strength Training':
                        exercises = ['Bench press', 'Incline Bench press', 'Push-ups', 'Chest press machine', 'Chest flys', 'Barbell or dumbbells press', 'Arnold press',
                            'Lateral raises', 'Face pulls', 'Front raises', 'Pull-ups or chin-ups', 'Lat pulldowns', 'Barbell rows', 'Deadlifts', 'Dumbbell rows', 'Bicep curls',
                            'Tricep dips', 'Hammer curls', 'Skull crushers', 'Squats', 'Step-ups', 'Lunges', 'Leg press', 'Romanian deadlifts', 'Hamstring curls', 'Glute bridges',
                            'Hip thrusts', 'Bulgarian split squats', 'Kettle bell swings'
                        ];
                        break;
                    case 'Cardiovascular exercises':
                        exercises = ['Running', 'Cycling', 'Jump Rope', 'Brisk Walking', 'Swimming'];
                        break;
                    case 'Plyometrics':
                        exercises = ['Pop Squat', 'Split Squat Jump', 'Alternating Lunge Squat', 'Reverse Lunge to Knee-Up Jump', 'Tuck Jump', 'Jump Squat With Heel Tap', 'Skater Hop',
                            'Burpee', 'Box Jump', 'Crab Walk to Jump', 'Single-Leg Deadlift to Jump', 'Lateral Lunge to Single-Leg Hop', 'Hands-Release Push-Up', 'Broad Jump to Burpee',
                            'Burpee Into Tuck Jump',
                        ];
                        break;
                    case 'Core Strength exercises':
                        exercises = ['Bridge', 'Superman', 'Quadruped', 'Side plank', 'Modified plank', 'Abdominal Crunch', 'Single-leg abdominal press', 'Double-leg abdominal press'];
                        break;
                }

                exercises.forEach(function (exercise) {
                    const option = document.createElement('option');
                    option.value = exercise;
                    option.textContent = exercise;
                    exerciseSelect.appendChild(option);
                });
            }
        </script>


        <!-- Modal for Editing Exercise -->
        @foreach($exercisesCustom as $exerciseCustom)
            <div class="modal fade" id="editExerciseModal{{ $exerciseCustom->id }}" tabindex="-1"
                aria-labelledby="editExerciseModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editExerciseModalLabel">Edit Exercise</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('exercise-custom.update', $exerciseCustom->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- User Details Section -->
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">User Name</label>
                                    <select class="form-control" name="user_id" id="user_id">
                                        <option value="">Select User</option>
                                        @foreach($approvedUsers as $userId => $userName)
                                            <option value="{{ $userId }}" {{ old('user_id', $exerciseCustom->user_id) == $userId ? 'selected' : '' }}>
                                                {{ $userName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category" name="category" value="Exercise"
                                        readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-control" id="type{{ $exerciseCustom->id }}" name="type" required
                                        onchange="updateExercises('{{ $exerciseCustom->id }}')">
                                        <option value="">Select Type</option>
                                        <option value="Strength Training" {{ $exerciseCustom->type == 'Strength Training' ? 'selected' : '' }}>Strength Training</option>
                                        <option value="Cardiovascular exercises" {{ $exerciseCustom->type == 'Cardiovascular exercises' ? 'selected' : '' }}>Cardiovascular exercises</option>
                                        <option value="Plyometrics" {{ $exerciseCustom->type == 'Plyometrics' ? 'selected' : '' }}> Plyometrics</option>
                                        <option value="Core Strength exercises" {{ $exerciseCustom->type == 'Core Strength exercises' ? 'selected' : '' }}>Core Strength exercises</option>
                                    </select>
                                </div>

                                <!-- Accordion for Details -->
                                <div class="accordion" id="editExerciseAccordion{{ $exerciseCustom->id }}">
                                    <!-- General Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingDetails{{ $exerciseCustom->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseDetails{{ $exerciseCustom->id }}"
                                                aria-expanded="true"
                                                aria-controls="editCollapseDetails{{ $exerciseCustom->id }}">
                                                General Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseDetails{{ $exerciseCustom->id }}"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="editHeadingDetails{{ $exerciseCustom->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="guideline{{ $exerciseCustom->id }}"
                                                        class="form-label">Guideline</label>
                                                    <textarea type="text" class="form-control"
                                                        id="guideline{{ $exerciseCustom->id }}" name="guideline"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $exerciseCustom->guideline }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exercise" class="form-label">Exercises</label>
                                                    <select class="form-control" id="exercise{{ $exerciseCustom->id }}"
                                                        name="exercise" required>
                                                        <option value="{{ $exerciseCustom->exercise }}" selected>
                                                            {{ $exerciseCustom->exercise }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description{{ $exerciseCustom->id }}"
                                                        class="form-label">Description</label>
                                                    <textarea type="text" class="form-control"
                                                        id="description{{ $exerciseCustom->id }}" name="description"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $exerciseCustom->description }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Exercise Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingExercises{{ $exerciseCustom->id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseExercises{{ $exerciseCustom->id }}"
                                                aria-expanded="false"
                                                aria-controls="editCollapseExercises{{ $exerciseCustom->id }}">
                                                Exercise Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseExercises{{ $exerciseCustom->id }}"
                                            class="accordion-collapse collapse"
                                            aria-labelledby="editHeadingExercises{{ $exerciseCustom->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="duration{{ $exerciseCustom->id }}"
                                                        class="form-label">Duration</label>
                                                    <input type="text" class="form-control"
                                                        id="duration{{ $exerciseCustom->id }}" name="duration"
                                                        value="{{ $exerciseCustom->duration }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Buttons Section -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Exercise</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Loop through each exercise and update the dropdown for each one
                    @foreach($exercisesCustom as $exerciseCustom)
                        updateExercises('{{ $exerciseCustom->id }}', '{{ $exerciseCustom->exercise }}');
                    @endforeach
                            });

                function updateExercises(exerciseId = '', selectedExercise = '') {
                    const type = document.getElementById('type' + exerciseId).value;
                    const exerciseSelect = document.getElementById('exercise' + exerciseId);

                    // Clear previous options
                    exerciseSelect.innerHTML = '<option value="">Select Exercise</option>';

                    let exercises = [];

                    switch (type) {
                        case 'Strength Training':
                            exercises = ['Bench press', 'Incline Bench press', 'Push-ups', 'Chest press machine', 'Chest flys', 'Barbell or dumbbells press', 'Arnold press',
                                'Lateral raises', 'Face pulls', 'Front raises', 'Pull-ups or chin-ups', 'Lat pulldowns', 'Barbell rows', 'Deadlifts', 'Dumbbell rows', 'Bicep curls',
                                'Tricep dips', 'Hammer curls', 'Skull crushers', 'Squats', 'Step-ups', 'Lunges', 'Leg press', 'Romanian deadlifts', 'Hamstring curls', 'Glute bridges',
                                'Hip thrusts', 'Bulgarian split squats', 'Kettle bell swings'];
                            break;
                        case 'Cardiovascular exercises':
                            exercises = ['Running', 'Cycling', 'Jump Rope', 'Brisk Walking', 'Swimming'];
                            break;
                        case 'Plyometrics':
                            exercises = ['Pop Squat', 'Split Squat Jump', 'Alternating Lunge Squat', 'Reverse Lunge to Knee-Up Jump', 'Tuck Jump', 'Jump Squat With Heel Tap', 'Skater Hop',
                                'Burpee', 'Box Jump', 'Crab Walk to Jump', 'Single-Leg Deadlift to Jump', 'Lateral Lunge to Single-Leg Hop', 'Hands-Release Push-Up', 'Broad Jump to Burpee',
                                'Burpee Into Tuck Jump'];
                            break;
                        case 'Core Strength exercises':
                            exercises = ['Bridge', 'Superman', 'Quadruped', 'Side plank', 'Modified plank', 'Abdominal Crunch', 'Single-leg abdominal press', 'Double-leg abdominal press'];
                            break;
                    }

                    exercises.forEach(function (exercise) {
                        const option = document.createElement('option');
                        option.value = exercise;
                        option.textContent = exercise;

                        // Set the selected option based on the previous exercise selection
                        if (exercise === selectedExercise) {
                            option.selected = true;
                        }

                        exerciseSelect.appendChild(option);
                    });
                }

            </script>



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