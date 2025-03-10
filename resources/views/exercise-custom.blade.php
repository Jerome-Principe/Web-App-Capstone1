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
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editExerciseModal{{ $exerciseCustom->id }}">Update</button>

                                    <!-- Delete Button (Form for DELETE request) -->
                                    <form action="{{ route('exercise-custom.destroy', $exerciseCustom->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this exercise?')">Delete</button>
                                    </form>
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
                        <h5 class="modal-title" id="addExerciseModalLabel">Add New Custom Exercise</h5>
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
                                <select class="form-control" id="type" name="type" required>
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
                                                <input type="text" class="form-control" id="guideline" name="guideline"
                                                    placeholder="Guideline">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exercise" class="form-label">Exercises</label>
                                                <select class="form-control" id="exercise" name="exercise">
                                                    <option value="">Select Exercise</option>
                                                    <option value="Chest">Chest</option>
                                                    <option value="Shoulders">Shoulders</option>
                                                    <option value="Back">Back</option>
                                                    <option value="Arms">Arms</option>
                                                    <option value="Legs Quad focused">Legs Quad focused</option>
                                                    <option value="Legs Hamstring focused">Legs Hamstring focused</option>
                                                    <option value="Glutes">Glutes</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <input type="text" class="form-control" id="description" name="description"
                                                    placeholder="Exercise">
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
                                                    placeholder="E.g., 30 minutes">
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

        <!-- Modal for Editing Exercise -->
        @foreach($exercisesCustom as $exerciseCustom)
            <div class="modal fade" id="editExerciseModal{{ $exerciseCustom->id }}" tabindex="-1"
                aria-labelledby="editExerciseModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editExerciseModalLabel">Edit Custom Exercise</h5>
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

                                @php
                                    $exerciseTypes = [
                                        'Strength Training',
                                        'Cardiovascular exercises',
                                        'Plyometrics',
                                        'Core Strength exercises',
                                    ];
                                @endphp

                                <div class="mb-3">
                                    <label for="type{{ $exerciseCustom->id }}" class="form-label">Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="">Select Type</option>
                                        @foreach($exerciseTypes as $type)
                                            <option value="{{ $type }}" {{ $exerciseCustom->type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
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
                                                    <input type="text" class="form-control"
                                                        id="guideline{{ $exerciseCustom->id }}" name="guideline"
                                                        value="{{ $exerciseCustom->guideline }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exercises{{ $exerciseCustom->id }}"
                                                        class="form-label">Exercises</label>
                                                    <select class="form-control" id="exercise{{ $exerciseCustom->id }}"
                                                        name="exercise">
                                                        @php
                                                            $Exercises = ['Chest', 'Shoulders', 'Back', 'Arms', 'Legs Quad focused', 'Legs Hamstring focused', 'Glutes'];
                                                        @endphp
                                                        @foreach($Exercises as $Exercise)
                                                            <option value="{{ $Exercise }}" {{ $exerciseCustom->Exercise == $Exercise ? 'selected' : '' }}>{{ $Exercise }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description{{ $exerciseCustom->id }}"
                                                        class="form-label">Description</label>
                                                    <input type="text" class="form-control"
                                                        id="description{{ $exerciseCustom->id }}" name="description"
                                                        value="{{ $exerciseCustom->description }}">
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