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
                <h1>Exercise Default List</h1>
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
                        @foreach($exercises as $exercise)
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="selected[]" value="{{ $exercise->id }}" />
                                </td>
                                <td class="text-center">{{ $exercise->id }}</td>
                                <td class="text-center">{{ $exercise->category }}</td>
                                <td class="text-center">{{ $exercise->type }}</td>
                                <td class="text-center">{{ $exercise->guideline }}</td>
                                <td class="text-center">{{ $exercise->exercise }}</td>
                                <td class="text-center">{{ $exercise->description }}</td>
                                <td class="text-center">{{ $exercise->duration }}</td>
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editExerciseModal{{ $exercise->id }}">Update</button>

                                    <!-- Delete Button (Form for DELETE request) -->
                                    <form action="{{ route('exercise.destroy', $exercise->id) }}" method="POST"
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
                        <li class="page-item {{ $exercises->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $exercises->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $exercises->lastPage()) as $page)
                            <li class="page-item {{ $page == $exercises->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $exercises->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$exercises->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $exercises->nextPageUrl() }}">Next</a>
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
                        <form action="{{ route('exercise.store') }}" method="POST">
                            @csrf

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
        @foreach($exercises as $exercise)
            <div class="modal fade" id="editExerciseModal{{ $exercise->id }}" tabindex="-1"
                aria-labelledby="editExerciseModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editExerciseModalLabel">Edit Exercise</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('exercise.update', $exercise->id) }}" method="POST">
                                @csrf
                                @method('PUT')

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
                                    <label for="type{{ $exercise->id }}" class="form-label">Type</label>
                                    <select class="form-control" name="type" required>
                                        <option value="">Select Type</option>
                                        @foreach($exerciseTypes as $type)
                                            <option value="{{ $type }}" {{ $exercise->type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Accordion for Details -->
                                <div class="accordion" id="editExerciseAccordion{{ $exercise->id }}">
                                    <!-- General Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingDetails{{ $exercise->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseDetails{{ $exercise->id }}" aria-expanded="true"
                                                aria-controls="editCollapseDetails{{ $exercise->id }}">
                                                General Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseDetails{{ $exercise->id }}"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="editHeadingDetails{{ $exercise->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="guideline{{ $exercise->id }}"
                                                        class="form-label">Guideline</label>
                                                    <input type="text" class="form-control" id="guideline{{ $exercise->id }}"
                                                        name="guideline" value="{{ $exercise->guideline }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exercises{{ $exercise->id }}"
                                                        class="form-label">Exercises</label>
                                                    <select class="form-control" id="exercise{{ $exercise->id }}"
                                                        name="exercise">
                                                        @php
                                                            $Exercises = ['Chest', 'Shoulders', 'Back', 'Arms', 'Legs Quad focused', 'Legs Hamstring focused', 'Glutes'];
                                                        @endphp
                                                        @foreach($Exercises as $Exercise)
                                                            <option value="{{ $Exercise }}" {{ $exercise->Exercise == $Exercise ? 'selected' : '' }}>{{ $Exercise }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="description{{ $exercise->id }}"
                                                        class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="description{{ $exercise->id }}"
                                                        name="description" value="{{ $exercise->description }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Exercise Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingExercises{{ $exercise->id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseExercises{{ $exercise->id }}" aria-expanded="false"
                                                aria-controls="editCollapseExercises{{ $exercise->id }}">
                                                Exercise Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseExercises{{ $exercise->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="editHeadingExercises{{ $exercise->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="duration{{ $exercise->id }}" class="form-label">Duration</label>
                                                    <input type="text" class="form-control" id="duration{{ $exercise->id }}"
                                                        name="duration" value="{{ $exercise->duration }}">
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