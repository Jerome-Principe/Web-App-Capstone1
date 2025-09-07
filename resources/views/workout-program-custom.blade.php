<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{asset('assets/images/muscle.png')}}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Workout Program Custom List</title>
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
                <h1>Workout Program Custom List</h1>
                <p>Track custom member workout programs and training progress</p>
            </div>

            <div class="content-card">
                <div class="header-section">
                    <div class="d-flex align-items-center">
                        <h1 class="mb-0 me-3">Workout Program Custom List</h1>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addWorkoutProgramModal"><i class="fa fa-plus mx-1" aria-hidden="true"></i>
                            Add New Workout Program Custom
                        </button>
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
                                <th class="text-center">Progress</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($workoutProgramsCustom->count() > 0)
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
                                            <span
                                                class="badge {{ $workoutProgramCustom->progress === 'Completed' ? 'bg-success' : 'bg-warning' }}">
                                                {{ $workoutProgramCustom->progress ?? 'Incomplete' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                                    data-bs-target="#editWorkoutProgramModal{{ $workoutProgramCustom->id }}">
                                                    <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                                </button>

                                                <!-- Delete Button (Form for DELETE request) -->
                                                <form action="{{ route('workout-program-custom.destroy', $workoutProgramCustom->id) }}" method="POST"
                                                    style="display:inline;">
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
                            @else
                                <!-- No Data State -->
                                <tr>
                                    <td colspan="12" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-running" style="font-size: 64px; color: #6c757d; margin-bottom: 20px; display: block;"></i>
                                            <h4 class="text-dark mb-2">No custom workout programs found</h4>
                                            <p class="text-muted">There are no custom workout program records to display.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    @if($workoutProgramsCustom->count() > 0)
                        <!-- Pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center mt-4 mb-4">
                                <li class="page-item {{ $workoutProgramsCustom->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $workoutProgramsCustom->previousPageUrl() }}" tabindex="-1">Previous</a>
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
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal for Adding Workout Program -->
        <div class="modal fade" id="addWorkoutProgramModal" tabindex="-1" aria-labelledby="addWorkoutProgramModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addWorkoutProgramModalLabel">Add New Workout Program Custom</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <form action="{{ route('workout-program-custom.store') }}" method="POST"
                            id="workoutProgramCustomForm">
                            @csrf

                            <!-- User Details Section -->
                            <div class="mb-3">
                                <label for="user_id" class="form-label">User Name</label>
                                <select class="form-control" name="user_id" id="user_id" required>
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
                                        Building Workout</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="guideline" class="form-label">Guideline</label>
                                <input type="text" class="form-control" id="guideline" name="guideline"
                                    placeholder="Enter guidelines..." required>
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
                                <textarea class="form-control" id="workout" name="workout"
                                    placeholder="Enter workout details..." required
                                    style="height: 80px; resize: none;"></textarea>
                            </div>

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

                            <div class="mb-3">
                                <label for="progress" class="form-label">Progress</label>
                                <select class="form-control" id="progress" name="progress" required>
                                    <option value="Incomplete" selected>Incomplete</option>
                                    <option value="Completed">Completed</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="workoutProgramCustomForm" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Workout Program -->
        @foreach($workoutProgramsCustom as $workoutProgramCustom)
            <div class="modal fade" id="editWorkoutProgramModal{{ $workoutProgramCustom->id }}" tabindex="-1"
                aria-labelledby="editWorkoutProgramModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editWorkoutProgramModalLabel">Edit Workout Program Custom</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                            <form action="{{ route('workout-program-custom.update', $workoutProgramCustom->id) }}" method="POST"
                                id="editWorkoutProgramCustomForm{{ $workoutProgramCustom->id }}">
                                @csrf
                                @method('PUT')

                                <!-- User Details Section -->
                                <div class="mb-3">
                                    <label for="user_id{{ $workoutProgramCustom->id }}" class="form-label">User Name</label>
                                    <select class="form-control" name="user_id" id="user_id{{ $workoutProgramCustom->id }}"
                                        required>
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
                                    <label for="category{{ $workoutProgramCustom->id }}" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category{{ $workoutProgramCustom->id }}"
                                        name="category" value="Workout Program" readonly>
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

                                <div class="mb-3">
                                    <label for="guideline{{ $workoutProgramCustom->id }}" class="form-label">Guideline</label>
                                    <input type="text" class="form-control" id="guideline{{ $workoutProgramCustom->id }}"
                                        name="guideline" value="{{ $workoutProgramCustom->guideline }}">
                                </div>

                                <div class="mb-3">
                                    <label for="day{{ $workoutProgramCustom->id }}" class="form-label">Day</label>
                                    <select class="form-control" id="day{{ $workoutProgramCustom->id }}" name="day">
                                        @php
                                            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                        @endphp
                                        @foreach($days as $day)
                                            <option value="{{ $day }}" {{ $workoutProgramCustom->day == $day ? 'selected' : '' }}>
                                                {{ $day }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="workout{{ $workoutProgramCustom->id }}" class="form-label">Workout</label>
                                    <textarea class="form-control" id="workout{{ $workoutProgramCustom->id }}" name="workout"
                                        style="height: 80px; resize: none;">{{ $workoutProgramCustom->workout }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="difficulty{{ $workoutProgramCustom->id }}" class="form-label">Difficulty</label>
                                    <input type="text" class="form-control" id="difficulty{{ $workoutProgramCustom->id }}"
                                        name="difficulty" value="{{ $workoutProgramCustom->difficulty }}">
                                </div>

                                <div class="mb-3">
                                    <label for="duration{{ $workoutProgramCustom->id }}" class="form-label">Duration</label>
                                    <input type="text" class="form-control" id="duration{{ $workoutProgramCustom->id }}"
                                        name="duration" value="{{ $workoutProgramCustom->duration }}">
                                </div>

                                <div class="mb-3">
                                    <label for="progress{{ $workoutProgramCustom->id }}" class="form-label">Progress</label>
                                    <select class="form-control" id="progress{{ $workoutProgramCustom->id }}" name="progress"
                                        required>
                                        <option value="Incomplete" {{ $workoutProgramCustom->progress == 'Incomplete' ? 'selected' : '' }}>Incomplete</option>
                                        <option value="Completed" {{ $workoutProgramCustom->progress == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" form="editWorkoutProgramCustomForm{{ $workoutProgramCustom->id }}"
                                class="btn btn-primary">Update</button>
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

        // Simple modal and form handling
        document.addEventListener('DOMContentLoaded', function() {
            const addWorkoutProgramModal = document.getElementById('addWorkoutProgramModal');
            const workoutProgramCustomForm = document.getElementById('workoutProgramCustomForm');
            
            if (addWorkoutProgramModal) {
                // Reset form when modal is hidden
                addWorkoutProgramModal.addEventListener('hidden.bs.modal', function() {
                    if (workoutProgramCustomForm) {
                        workoutProgramCustomForm.reset();
                    }
                });
            }
            
            // Simple form validation
            if (workoutProgramCustomForm) {
                workoutProgramCustomForm.addEventListener('submit', function(e) {
                    const requiredFields = workoutProgramCustomForm.querySelectorAll('[required]');
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

@endsection