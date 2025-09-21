<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{asset('assets/images/muscle.png')}}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Exercise Default List</title>
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

        .container {
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

        /* Page Header */
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

        /* Minimalist Header */
        .header-section {
            text-align: center;
            margin-bottom: 48px;
            padding: 0;
        }

        .header-section h1 {
            font-size: 28px;
            font-weight: 400;
            color: #333;
            margin: 0 0 8px 0;
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

        .filter-options a.active {
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
            vertical-align: middle;
            text-align: center !important;
            min-width: 100px;
        }

        tbody tr:hover {
            background: #f8f9fa;
        }

        /* Minimalist Checkbox */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #007bff;
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

        /* Minimalist Alert */
        .custom-alert-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
            font-size: 14px;
            margin-left: 16px;
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

        .modal {
            z-index: 1055;
        }

        /* Modal scrolling improvements */
        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 15px 20px;
        }

        /* Simple form styling */
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        /* Form validation styles */
        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control.is-valid {
            border-color: #198754;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container {
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
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Exercise Default List</h1>
                <p>Manage default exercise templates and routines</p>
            </div>

            <div class="content-card">
                <div class="header-section">
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-3 mb-2" style="justify-content: space-between;">
                            <div>
                                <h1 class="card-title mb-0" style="font-size: 20px; font-weight: 500; color: #333;">Exercise
                                    Default List</h1>
                                <p class="text-muted mb-0">Manage default exercise templates and routines</p>
                            </div>
                            <button type="button" class="btn btn-primary d-inline-flex align-items-center"
                                data-bs-toggle="modal" data-bs-target="#addExerciseModal">
                                <i class="fa fa-plus mr-2"></i>
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
                    </div>

                    <div>
                        <div class="d-flex align-items-center">
                            <form class="d-flex" role="search" method="GET" action="{{ route('exercise.index') }}">
                                <input class="form-control" type="search" name="search" placeholder="Search exercises..."
                                    aria-label="Search" value="{{ request('search') }}" style="height: 35px;"
                                    id="searchInput">
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
                            @if($exercises->count() > 0)
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
                                            <div class="d-flex justify-content-center">
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                                    data-bs-target="#editExerciseModal{{ $exercise->id }}">
                                                    <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                                </button>

                                                <!-- Delete Button (Form for DELETE request) -->
                                                <form action="{{ route('exercise.destroy', $exercise->id) }}" method="POST"
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
                            @else
                                <!-- No Data State -->
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-dumbbell"
                                                style="font-size: 64px; color: #6c757d; margin-bottom: 20px; display: block;"></i>
                                            <h4 class="text-dark mb-2">No exercises found</h4>
                                            <p class="text-muted">There are no exercise records to display.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    @if($exercises->count() > 0)
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
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal for Adding Exercise Program -->
        <div class="modal fade" id="addExerciseModal" tabindex="-1" aria-labelledby="addExerciseModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExerciseModalLabel">Add New Exercise</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <form action="{{ route('exercise.store') }}" method="POST" id="exerciseForm">
                            @csrf

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
                                    <option value="Core Strength exercises">Core Strength exercises</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="guideline" class="form-label">Guideline</label>
                                <textarea class="form-control" id="guideline" name="guideline"
                                    placeholder="Enter guidelines..." required
                                    style="height: 80px; resize: none;"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="exercise" class="form-label">Exercises</label>
                                <select class="form-control" id="exercise" name="exercise" required>
                                    <option value="">Select Exercise</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description"
                                    placeholder="Enter exercise description..." required
                                    style="height: 80px; resize: none;"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration"
                                    placeholder="E.g., 30 minutes" required>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="exerciseForm" class="btn btn-primary">Save</button>
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
        @foreach($exercises as $exercise)
            <div class="modal fade" id="editExerciseModal{{ $exercise->id }}" tabindex="-1"
                aria-labelledby="editExerciseModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editExerciseModalLabel">Edit Exercise</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <form action="{{ route('exercise.update', $exercise->id) }}" method="POST"
                                id="editExerciseForm{{ $exercise->id }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="category{{ $exercise->id }}" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category{{ $exercise->id }}" name="category"
                                        value="Exercise" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="type{{ $exercise->id }}" class="form-label">Type</label>
                                    <select class="form-control" id="type{{ $exercise->id }}" name="type" required
                                        onchange="updateExercises('{{ $exercise->id }}')">
                                        <option value="Strength Training" {{ $exercise->type == 'Strength Training' ? 'selected' : '' }}>Strength Training</option>
                                        <option value="Cardiovascular exercises" {{ $exercise->type == 'Cardiovascular exercises' ? 'selected' : '' }}>Cardiovascular exercises</option>
                                        <option value="Plyometrics" {{ $exercise->type == 'Plyometrics' ? 'selected' : '' }}>
                                            Plyometrics</option>
                                        <option value="Core Strength exercises" {{ $exercise->type == 'Core Strength exercises' ? 'selected' : '' }}>Core Strength exercises</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="guideline{{ $exercise->id }}" class="form-label">Guideline</label>
                                    <textarea class="form-control" id="guideline{{ $exercise->id }}" name="guideline"
                                        style="height: 80px; resize: none;">{{ $exercise->guideline }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="exercise{{ $exercise->id }}" class="form-label">Exercises</label>
                                    <select class="form-control" id="exercise{{ $exercise->id }}" name="exercise" required>
                                        <option value="{{ $exercise->exercise }}" selected>{{ $exercise->exercise }}</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="description{{ $exercise->id }}" class="form-label">Description</label>
                                    <textarea class="form-control" id="description{{ $exercise->id }}" name="description"
                                        style="height: 80px; resize: none;">{{ $exercise->description }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="duration{{ $exercise->id }}" class="form-label">Duration</label>
                                    <input type="text" class="form-control" id="duration{{ $exercise->id }}" name="duration"
                                        value="{{ $exercise->duration }}">
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="editExerciseForm{{ $exercise->id }}"
                                class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Loop through each exercise and update the dropdown for each one
                @foreach($exercises as $exercise)
                    updateExercises('{{ $exercise->id }}', '{{ $exercise->exercise }}');
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

            // Simple modal and form handling
            document.addEventListener('DOMContentLoaded', function () {
                const addExerciseModal = document.getElementById('addExerciseModal');
                const exerciseForm = document.getElementById('exerciseForm');

                if (addExerciseModal) {
                    // Reset form when modal is hidden
                    addExerciseModal.addEventListener('hidden.bs.modal', function () {
                        if (exerciseForm) {
                            exerciseForm.reset();
                        }
                    });
                }

                // Simple form validation
                if (exerciseForm) {
                    exerciseForm.addEventListener('submit', function (e) {
                        const requiredFields = exerciseForm.querySelectorAll('[required]');
                        let isValid = true;

                        requiredFields.forEach(field => {
                            if (!field.value.trim()) {
                                isValid = false;
                                field.classList.add('is-invalid');
                            } else {
                                field.classList.remove('is-invalid');
                            }
                        });

                        if (!isValid) {
                            e.preventDefault();
                            alert('Please fill in all required fields.');
                        }
                    });
                }
            });
        </script>

        <script>
            // Live search functionality for exercises
            document.addEventListener('DOMContentLoaded', function () {
                const searchInput = document.getElementById('searchInput');
                const tableContainer = document.querySelector('.table-container');
                const paginationContainer = document.querySelector('.pagination');
                let searchTimeout;

                if (searchInput) {
                    searchInput.addEventListener('input', function () {
                        clearTimeout(searchTimeout);

                        // Debounce search to avoid too many requests
                        searchTimeout = setTimeout(() => {
                            performLiveSearch(this.value);
                        }, 300);
                    });
                }

                function performLiveSearch(searchTerm) {
                    // Show loading state
                    if (tableContainer) {
                        tableContainer.style.opacity = '0.6';
                    }

                    const url = new URL(window.location.href);
                    url.searchParams.set('search', searchTerm);

                    fetch(url.toString(), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html, application/xhtml+xml'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            // Create a temporary div to parse the HTML
                            const tempDiv = document.createElement('div');
                            tempDiv.innerHTML = html;

                            // Extract and update the table content
                            const newTableContainer = tempDiv.querySelector('.table-container');
                            if (newTableContainer && tableContainer) {
                                tableContainer.innerHTML = newTableContainer.innerHTML;
                            }

                            // Extract and update pagination
                            const newPagination = tempDiv.querySelector('.pagination');
                            if (newPagination && paginationContainer) {
                                paginationContainer.innerHTML = newPagination.innerHTML;
                            }

                            // Reset opacity
                            if (tableContainer) {
                                tableContainer.style.opacity = '1';
                            }

                            // Update URL without page reload
                            history.pushState(null, '', url.toString());
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            if (tableContainer) {
                                tableContainer.style.opacity = '1';
                            }
                        });
                }

                // Handle pagination clicks for search results
                document.addEventListener('click', function (e) {
                    if (e.target.closest('.pagination a')) {
                        e.preventDefault();
                        const link = e.target.closest('.pagination a');
                        const href = link.getAttribute('href');

                        if (href) {
                            fetch(href, {
                                method: 'GET',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'text/html, application/xhtml+xml'
                                }
                            })
                                .then(response => response.text())
                                .then(html => {
                                    const tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = html;

                                    const newTableContainer = tempDiv.querySelector('.table-container');
                                    if (newTableContainer && tableContainer) {
                                        tableContainer.innerHTML = newTableContainer.innerHTML;
                                    }

                                    const newPagination = tempDiv.querySelector('.pagination');
                                    if (newPagination && paginationContainer) {
                                        paginationContainer.innerHTML = newPagination.innerHTML;
                                    }

                                    // Update URL
                                    history.pushState(null, '', href);
                                })
                                .catch(error => {
                                    console.error('Pagination error:', error);
                                });
                        }
                    }
                });
            });
        </script>

    </body>
@endsection