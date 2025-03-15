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
                    <a href="#">Archived (0)</a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-light border mx-2" style="height: 35px;"
                            onclick="return confirm('Are you sure you want to move all these meal plans to the archive?')">
                            <i class="fa fa-trash"></i> Move to Archive
                        </button>

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
                                <td class="text-center">{{ $mealPlanCustom->id }}</td>
                                <td class="text-center">{{ $mealPlanCustom->user->name ?? 'User Not Found' }}</td>
                                <td class="text-center">{{ $mealPlanCustom->category }}</td>
                                <td class="text-center">{{ $mealPlanCustom->type }}</td>
                                <td class="text-center">{{ $mealPlanCustom->guideline }}</td>
                                <td class="text-center">{{ $mealPlanCustom->day }}</td>
                                <td class="text-center">{{ $mealPlanCustom->breakfast }}</td>
                                <td class="text-center">{{ $mealPlanCustom->lunch }}</td>
                                <td class="text-center">{{ $mealPlanCustom->dinner }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <!-- Edit Button -->
                                        <button type="button" class="btn btn-sm btn-primary mx-1" data-bs-toggle="modal"
                                            data-bs-target="#editMealPlanModal{{ $mealPlanCustom->id }}">
                                            <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                        </button>

                                        <!-- Delete Button (Form for DELETE request) -->
                                        <form action="{{ route('meal-plan-custom.destroy', $mealPlanCustom->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this meal plan?')">
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

                            <!-- Category and Type Section -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" class="form-control" id="category" name="category"
                                    value="Meal Plan Guide" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-control" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="WEIGHT LOSS">WEIGHT LOSS</option>
                                    <option value="BUILD MUSCLE">BUILD MUSCLE</option>
                                    <option value="GAIN WEIGHT">GAIN WEIGHT</option>
                                    <option value="BUILD ENDURANCE">BUILD ENDURANCE</option>
                                    <option value="LOSS WEIGHT & BUILD MUSCLE">LOSS WEIGHT & BUILD MUSCLE</option>
                                    <option value="STRENGTH & CONDITIONING">STRENGTH & CONDITIONING</option>
                                    <option value="HIGH INTENSITY TRAINING">HIGH INTENSITY TRAINING</option>
                                    <option value="ATHLETIC TRAINING">ATHLETIC TRAINING</option>
                                    <option value="CIRCUIT CROSSFIT">CIRCUIT CROSSFIT</option>
                                    <option value="WEIGHT TRAINING">WEIGHT TRAINING</option>
                                    <option value="BODY BUILDING">BODY BUILDING</option>
                                    <option value="AEROBOXING">AEROBOXING</option>
                                    <option value="KICK BOXING">KICK BOXING</option>
                                    <option value="TAEKWONDO">TAEKWONDO</option>
                                    <option value="BOXING">BOXING</option>
                                    <option value="CARDIO">CARDIO</option>
                                    <option value="WEIGHT LIFTING">WEIGHT LIFTING</option>
                                    <option value="ZUMBA">ZUMBA</option>
                                    <option value="YOGA">YOGA</option>
                                    <option value="POLE DANCING">POLE DANCING</option>
                                </select>
                            </div>

                            <!-- Collapsible Section for Details -->
                            <div class="accordion" id="mealPlanAccordion">
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
                                        </div>
                                    </div>
                                </div>

                                <!-- Meal Details -->
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingMeals">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseMeals" aria-expanded="false"
                                            aria-controls="collapseMeals">
                                            Meal Details
                                        </button>
                                    </h2>
                                    <div id="collapseMeals" class="accordion-collapse collapse"
                                        aria-labelledby="headingMeals">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <label for="breakfast" class="form-label">Breakfast</label>
                                                <textarea type="text" class="form-control" id="breakfast" name="breakfast"
                                                    placeholder="E.g., Pandesal" required
                                                    style="height: 100px; resize: none; white-space: pre-wrap;"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="lunch" class="form-label">Lunch</label>
                                                <textarea type="text" class="form-control" id="lunch" name="lunch"
                                                    placeholder="E.g., Grilled meats" required
                                                    style="height: 100px; resize: none; white-space: pre-wrap;"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="dinner" class="form-label">Dinner</label>
                                                <textarea type="text" class="form-control" id="dinner" name="dinner"
                                                    placeholder="E.g., Adobo" required
                                                    style="height: 100px; resize: none; white-space: pre-wrap;"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Buttons -->
                            <div class="d-flex justify-content-end mt-3">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Add Meal Plan</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

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

                                <!-- User Details Section -->
                                <div class="mb-3">
                                    <label for="user_id{{ $mealPlanCustom->id }}" class="form-label">User Name</label>
                                    <select class="form-control" name="user_id" id="user_id{{ $mealPlanCustom->id }}">
                                        <option value="">Select User</option>
                                        @foreach($approvedUsers as $userId => $userName)
                                            <option value="{{ $userId }}" {{ old('user_id', $mealPlanCustom->user_id) == $userId ? 'selected' : '' }}>
                                                {{ $userName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Category and Type Section -->
                                <div class="mb-3">
                                    <label for="category{{ $mealPlanCustom->id }}" class="form-label">Category</label>
                                    <select class="form-control" id="category{{ $mealPlanCustom->id }}" name="category"
                                        onchange="updateTypeDropdownEdit('{{ $mealPlanCustom->id }}')" required>
                                        <option value="">Select Category</option>
                                        <option value="Meal Plan Guide" {{ $mealPlanCustom->category == 'Meal Plan Guide' ? 'selected' : '' }}>Meal Plan Guide</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="type{{ $mealPlanCustom->id }}" class="form-label">Type</label>
                                    <select class="form-control" id="type{{ $mealPlanCustom->id }}" name="type" required>
                                        @if($mealPlanCustom->category == 'Meal Plan Guide')
                                            @foreach(['WEIGHT LOSS', 'BUILD MUSCLE', 'GAIN WEIGHT'] as $type)
                                                <option value="{{ $type }}" {{ $mealPlanCustom->type == $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Accordion for Details -->
                                <div class="accordion" id="editMealPlanAccordion{{ $mealPlanCustom->id }}">
                                    <!-- General Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingDetails{{ $mealPlanCustom->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseDetails{{ $mealPlanCustom->id }}"
                                                aria-expanded="true"
                                                aria-controls="editCollapseDetails{{ $mealPlanCustom->id }}">
                                                General Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseDetails{{ $mealPlanCustom->id }}"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="editHeadingDetails{{ $mealPlanCustom->id }}">
                                            <div class="accordion-body">

                                                <div class="mb-3">
                                                    <label for="guideline{{ $mealPlanCustom->id }}" class="form-label">
                                                        Guideline
                                                    </label>

                                                    <textarea class="form-control" id="guideline{{ $mealPlanCustom->id }}"
                                                        name="guideline"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $mealPlanCustom->guideline }}
                                                                                                    </textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="day{{ $mealPlanCustom->id }}" class="form-label">
                                                        Day
                                                    </label>

                                                    <select class="form-control" id="day{{ $mealPlanCustom->id }}" name="day"
                                                        value="{{ $mealPlanCustom->day }}">
                                                        <option value="Monday" {{ $mealPlanCustom->day == 'Monday' ? 'selected' : '' }}>Monday</option>
                                                        <option value="Tuesday" {{ $mealPlanCustom->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                                        <option value="Wednesday" {{ $mealPlanCustom->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                                        <option value="Thursday" {{ $mealPlanCustom->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                                        <option value="Friday" {{ $mealPlanCustom->day == 'Friday' ? 'selected' : '' }}>Friday</option>
                                                        <option value="Saturday" {{ $mealPlanCustom->day == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                                        <option value="Sunday" {{ $mealPlanCustom->day == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Meal Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingMeals{{ $mealPlanCustom->id }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseMeals{{ $mealPlanCustom->id }}"
                                                aria-expanded="false"
                                                aria-controls="editCollapseMeals{{ $mealPlanCustom->id }}">
                                                Meal Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseMeals{{ $mealPlanCustom->id }}" class="accordion-collapse collapse"
                                            aria-labelledby="editHeadingMeals{{ $mealPlanCustom->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="breakfast{{ $mealPlanCustom->id }}"
                                                        class="form-label">Breakfast</label>
                                                    <textarea class="form-control" id="breakfast{{ $mealPlanCustom->id }}"
                                                        name="breakfast"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $mealPlanCustom->breakfast }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="lunch{{ $mealPlanCustom->id }}" class="form-label">Lunch</label>
                                                    <textarea class="form-control" id="lunch{{ $mealPlanCustom->id }}"
                                                        name="lunch"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $mealPlanCustom->lunch }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dinner{{ $mealPlanCustom->id }}"
                                                        class="form-label">Dinner</label>
                                                    <textarea class="form-control" id="dinner{{ $mealPlanCustom->id }}"
                                                        name="dinner"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $mealPlanCustom->dinner }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Buttons Section -->
                                <div class="d-flex justify-content-end mt-3">
                                    <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Meal Plan</button>
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