<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Meal Plan Custom List</title>
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
            <h1>Meal Plan Custom List</h1>
            <!-- Button to trigger modal -->
            <div>
                <div class="d-flex justify-content-end position-relative">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addMealPlanModal"><i class="fa fa-plus mx-1" aria-hidden="true"></i>
                        Add New Meal Plan
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
                        <th class="text-center">User Name</th>
                        <th class="text-center">Category</th>
                        <th class="text-center">Type</th>
                        <th class="text-center">Guideline</th>
                        <th class="text-center">Day</th>
                        <th class="text-center">Breakfast</th>
                        <th class="text-center">Lunch</th>
                        <th class="text-center">Dinner</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mealPlansCustom as $mealPlanCustom)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="selected[]" value="{{ $mealPlanCustom->id }}" />
                            </td>
                            <td class="text-center">
                                {{ ($mealPlansCustom->currentPage() - 1) * $mealPlansCustom->perPage() + $loop->index + 1 }}
                            </td>
                            <td class="text-center">{{ $mealPlanCustom->user->name ?? 'User Not Found' }}</td>
                            <td class="text-center">{{ $mealPlanCustom->category }}</td>
                            <td class="text-center">{{ $mealPlanCustom->type }}</td>
                            <td class="text-center">{{ $mealPlanCustom->guideline }}</td>
                            <td class="text-center">{{ $mealPlanCustom->day }}</td>
                            <td class="text-center">{{ $mealPlanCustom->breakfast }}</td>
                            <td class="text-center">{{ $mealPlanCustom->lunch }}</td>
                            <td class="text-center">{{ $mealPlanCustom->dinner }}</td>
                            <td class="text-center">
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editMealPlanModal{{ $mealPlanCustom->id }}">Update</button>

                                <!-- Delete Button (Form for DELETE request) -->
                                <form action="{{ route('meal-plan-custom.destroy', $mealPlanCustom->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this meal plan?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mt-4 mb-4">
                    <li class="page-item {{ $mealPlansCustom->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $mealPlansCustom->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>

                    @foreach(range(1, $mealPlansCustom->lastPage()) as $page)
                        <li class="page-item {{ $page == $mealPlansCustom->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $mealPlansCustom->url($page) }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ !$mealPlansCustom->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $mealPlansCustom->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>
        </div>

    </div>

    <!-- Modal for Adding Meal Plan -->
    <div class="modal fade" id="addMealPlanModal" tabindex="-1" aria-labelledby="addMealPlanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMealPlanModalLabel">Add New Meal Plan Custom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('meal-plan-custom.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="user_id" class="form-label">User Name</label>
                            <select class="form-control" name="user_id" id="user_id">
                                <option value="">Select User</option>
                                @foreach($approvedUsers as $userId => $userName)
                                    <option value="{{ $userId }}" {{ (old('user_id', $mealPlanCustom->user_id) == $userId) ? 'selected' : '' }}>
                                        {{ $userName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="category" class="form-label">Category</label>
                            <select class="form-control" id="category" name="category" onchange="updateTypeDropdown()"
                                required>
                                <option value="">Select Category</option>
                                <option value="Meal Plan Guide">Meal Plan Guide</option>
                                <option value="Workout Program">Workout Program</option>
                                <option value="Exercise">Exercise</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="guideline" class="form-label">Guideline</label>
                            <input type="text" class="form-control" id="guideline" name="guideline"
                                placeholder="E.g., Drink water">
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
                            <label for="breakfast" class="form-label">Breakfast</label>
                            <input type="text" class="form-control" id="breakfast" name="breakfast"
                                placeholder="E.g., Pandesal ">
                        </div>

                        <div class="mb-3">
                            <label for="lunch" class="form-label">Lunch</label>
                            <input type="text" class="form-control" id="lunch" name="lunch"
                                placeholder="E.g., Grilled meats">
                        </div>

                        <div class="mb-3">
                            <label for="dinner" class="form-label">Dinner</label>
                            <input type="text" class="form-control" id="dinner" name="dinner" placeholder="E.g., Adobo">
                        </div>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Meal Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for dynamic dropdown -->
    <script>
        function updateTypeDropdown() {
            const category = document.getElementById('category').value;
            const typeDropdown = document.getElementById('type');

            // Clear current options
            typeDropdown.innerHTML = '<option value="">Select Type</option>';

            // Define options for each category
            const options = {
                'Meal Plan Guide': [
                    'WEIGHT LOSS', 'BUILD MUSCLE', 'GAIN WEIGHT', 'BUILD ENDURANCE',
                    'LOSS WEIGHT & BUILD MUSCLE', 'STRENGTH & CONDITIONING',
                    'HIGH INTENSITY TRAINING', 'ATHLETIC TRAINING', 'CIRCUIT CROSSFIT',
                    'WEIGHT TRAINING', 'BODY BUILDING', 'AEROBOXING', 'KICK BOXING',
                    'TAEKWONDO', 'BOXING', 'CARDIO', 'WEIGHT LIFTING', 'ZUMBA', 'YOGA', 'POLE DANCING'
                ],
                'Workout Program': [
                    '8 Weeks Fat Loss Workout for Beginners',
                    '8 Weeks Muscle-Building Workout Program',
                    '6 Days Push/Pull/Legs (PPL) Powerbuilding Workout Split',
                    '3 Days Push/Pull/Legs (PPL) Workout for Beginners'
                ],
                'Exercise': [
                    'Plyometrics Training', 'Cardiovascular Exercises', 'Plyometrics',
                    'Core Strength Exercises'
                ]
            };

            // Populate dropdown based on selected category
            if (options[category]) {
                options[category].forEach(option => {
                    const newOption = document.createElement('option');
                    newOption.value = option;
                    newOption.textContent = option;
                    typeDropdown.appendChild(newOption);
                });
            }
        }

        function updateTypeDropdownEdit(mealPlanCustomId) {
            const category = document.getElementById('category' + mealPlanCustomId).value;
            const typeDropdown = document.getElementById('type' + mealPlanCustomId);

            // Clear current options
            typeDropdown.innerHTML = '<option value="">Select Type</option>';

            // Define options for each category
            const options = {
                'Meal Plan Guide': [
                    'WEIGHT LOSS', 'BUILD MUSCLE', 'GAIN WEIGHT', 'BUILD ENDURANCE',
                    'LOSS WEIGHT & BUILD MUSCLE', 'STRENGTH & CONDITIONING',
                    'HIGH INTENSITY TRAINING', 'ATHLETIC TRAINING', 'CIRCUIT CROSSFIT',
                    'WEIGHT TRAINING', 'BODY BUILDING', 'AEROBOXING', 'KICK BOXING',
                    'TAEKWONDO', 'BOXING', 'CARDIO', 'WEIGHT LIFTING', 'ZUMBA', 'YOGA', 'POLE DANCING'
                ],
                'Workout Program': [
                    '8 Weeks Fat Loss Workout for Beginners',
                    '8 Weeks Muscle-Building Workout Program',
                    '6 Days Push/Pull/Legs (PPL) Powerbuilding Workout Split',
                    '3 Days Push/Pull/Legs (PPL) Workout for Beginners'
                ],
                'Exercise': [
                    'Plyometrics Training', 'Cardiovascular Exercises', 'Plyometrics',
                    'Core Strength Exercises'
                ]
            };

            // Populate dropdown based on selected category
            if (options[category]) {
                options[category].forEach(option => {
                    const newOption = document.createElement('option');
                    newOption.value = option;
                    newOption.textContent = option;
                    typeDropdown.appendChild(newOption);
                });
            }

            // Set the current type value if it matches any of the options
            const currentType = document.getElementById('type' + mealPlanCustomId).dataset.currentType;
            if (currentType && options[category].includes(currentType)) {
                typeDropdown.value = currentType;
            }
        }
    </script>

    <!-- Modal for Editing Meal Plan -->
    @foreach($mealPlansCustom as $mealPlanCustom)
        <div class="modal fade" id="editMealPlanModal{{ $mealPlanCustom->id }}" tabindex="-1"
            aria-labelledby="editMealPlanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMealPlanModalLabel">Edit Meal Plan Custom</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('meal-plan-custom.update', $mealPlanCustom->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="user_id{{ $mealPlanCustom->id }}" class="form-label">User ID</label>
                                <select class="form-control" name="user_id" id="user_id{{ $mealPlanCustom->id }}">
                                    <option value="">Select User ID</option>
                                    @foreach($approvedUsers as $userId)
                                        <option value="{{ $userId }}" {{ $mealPlanCustom->user_id == $userId ? 'selected' : '' }}>
                                            {{ $userId }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="category{{ $mealPlanCustom->id }}" class="form-label">Category</label>
                                <select class="form-control" id="category{{ $mealPlanCustom->id }}" name="category"
                                    onchange="updateTypeDropdownEdit('{{ $mealPlanCustom->id }}')" required>
                                    <option value="">Select Category</option>
                                    <option value="Meal Plan Guide" {{ $mealPlanCustom->category == 'Meal Plan Guide' ? 'selected' : '' }}>
                                        Meal Plan Guide
                                    </option>
                                    <option value="Workout Program" {{ $mealPlanCustom->category == 'Workout Program' ? 'selected' : '' }}>
                                        Workout Program
                                    </option>
                                    <option value="Exercise" {{ $mealPlanCustom->category == 'Exercise' ? 'selected' : '' }}>
                                        Exercise
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="type{{ $mealPlanCustom->id }}" class="form-label">Type</label>
                                <select class="form-control" id="type{{ $mealPlanCustom->id }}" name="type" required>
                                    <!-- Dynamically load types for editing -->
                                    @if($mealPlanCustom->category == 'Meal Plan Guide')
                                        @foreach(['WEIGHT LOSS', 'BUILD MUSCLE', 'GAIN WEIGHT', 'BUILD ENDURANCE', 'LOSS WEIGHT & BUILD MUSCLE', 'STRENGTH & CONDITIONING', 'HIGH INTENSITY TRAINING', 'ATHLETIC TRAINING', 'CIRCUIT CROSSFIT', 'WEIGHT TRAINING', 'BODY BUILDING', 'AEROBOXING', 'KICK BOXING', 'TAEKWONDO', 'BOXING', 'CARDIO', 'WEIGHT LIFTING', 'ZUMBA', 'YOGA', 'POLE DANCING'] as $type)
                                            <option value="{{ $type }}" {{ $mealPlanCustom->type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    @elseif($mealPlanCustom->category == 'Workout Program')
                                        @foreach(['8 Weeks Fat Loss Workout for Beginners', '8 Weeks Muscle-Building Workout Program', '6 Days Push/Pull/Legs (PPL) Powerbuilding Workout Split', '3 Days Push/Pull/Legs (PPL) Workout for Beginners'] as $type)
                                            <option value="{{ $type }}" {{ $mealPlanCustom->type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    @elseif($mealPlanCustom->category == 'Exercise')
                                        @foreach(['Plyometrics Training', 'Cardiovascular Exercises', 'Plyometrics', 'Core Strength Exercises'] as $type)
                                            <option value="{{ $type }}" {{ $mealPlanCustom->type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="guideline" class="form-label">Guideline</label>
                                <input type="text" class="form-control" id="guideline" name="guideline"
                                    value="{{ $mealPlanCustom->guideline }}">
                            </div>

                            <div class="mb-3">
                                <label for="day{{ $mealPlanCustom->id }}" class="form-label">Day</label>
                                <select class="form-control" id="day{{ $mealPlanCustom->id }}" name="day">
                                    <option value="Monday" {{ $mealPlanCustom->day == 'Monday' ? 'selected' : '' }}>Monday
                                    </option>
                                    <option value="Tuesday" {{ $mealPlanCustom->day == 'Tuesday' ? 'selected' : '' }}>Tuesday
                                    </option>
                                    <option value="Wednesday" {{ $mealPlanCustom->day == 'Wednesday' ? 'selected' : '' }}>
                                        Wednesday
                                    </option>
                                    <option value="Thursday" {{ $mealPlanCustom->day == 'Thursday' ? 'selected' : '' }}>
                                        Thursday
                                    </option>
                                    <option value="Friday" {{ $mealPlanCustom->day == 'Friday' ? 'selected' : '' }}>Friday
                                    </option>
                                    <option value="Saturday" {{ $mealPlanCustom->day == 'Saturday' ? 'selected' : '' }}>
                                        Saturday
                                    </option>
                                    <option value="Sunday" {{ $mealPlanCustom->day == 'Sunday' ? 'selected' : '' }}>Sunday
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="breakfast" class="form-label">Breakfast</label>
                                <input type="text" class="form-control" id="breakfast" name="breakfast"
                                    value="{{ $mealPlanCustom->breakfast }}">
                            </div>

                            <div class="mb-3">
                                <label for="lunch" class="form-label">Lunch</label>
                                <input type="text" class="form-control" id="lunch" name="lunch"
                                    value="{{ $mealPlanCustom->lunch }}">
                            </div>

                            <div class="mb-3">
                                <label for="dinner" class="form-label">Dinner</label>
                                <input type="text" class="form-control" id="dinner" name="dinner"
                                    value="{{ $mealPlanCustom->dinner }}">
                            </div>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
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