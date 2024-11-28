<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Meal Plan</title>
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
            <h1>Meal Plan List</h1>
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
                        <th class="text-center">Guideline</th>
                        <th class="text-center">Day</th>
                        <th class="text-center">Breakfast</th>
                        <th class="text-center">Lunch</th>
                        <th class="text-center">Dinner</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mealPlans as $mealPlan)
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="selected[]" value="{{ $mealPlan->id }}" />
                            </td>
                            <td class="text-center">
                                {{ ($mealPlans->currentPage() - 1) * $mealPlans->perPage() + $loop->index + 1 }}
                            </td>
                            <td class="text-center">{{ $mealPlan->guideline }}</td>
                            <td class="text-center">{{ $mealPlan->day }}</td>
                            <td class="text-center">{{ $mealPlan->breakfast }}</td>
                            <td class="text-center">{{ $mealPlan->lunch }}</td>
                            <td class="text-center">{{ $mealPlan->dinner }}</td>
                            <td class="text-center">
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editMealPlanModal{{ $mealPlan->id }}">Edit</button>

                                <!-- Delete Button (Form for DELETE request) -->
                                <form action="{{ route('meal-plan.destroy', $mealPlan->id) }}" method="POST"
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
                    <li class="page-item {{ $mealPlans->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $mealPlans->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>

                    @foreach(range(1, $mealPlans->lastPage()) as $page)
                        <li class="page-item {{ $page == $mealPlans->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $mealPlans->url($page) }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ !$mealPlans->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $mealPlans->nextPageUrl() }}">Next</a>
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
                    <h5 class="modal-title" id="addMealPlanModalLabel">Add New Meal Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('meal-plan.store') }}" method="POST">
                        @csrf
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
                                placeholder="E.g., Grilled chicken">
                        </div>

                        <div class="mb-3">
                            <label for="lunch" class="form-label">Lunch</label>
                            <input type="text" class="form-control" id="lunch" name="lunch"
                                placeholder="E.g., Grilled chicken">
                        </div>

                        <div class="mb-3">
                            <label for="dinner" class="form-label">Dinner</label>
                            <input type="text" class="form-control" id="dinner" name="dinner"
                                placeholder="E.g., Grilled chicken">
                        </div>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Meal Plan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Meal Plan -->
    @foreach($mealPlans as $mealPlan)
        <div class="modal fade" id="editMealPlanModal{{ $mealPlan->id }}" tabindex="-1"
            aria-labelledby="editMealPlanModalLabel{{ $mealPlan->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editMealPlanModalLabel{{ $mealPlan->id }}">Edit Meal Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('meal-plan.update', $mealPlan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="guideline" class="form-label">Guideline</label>
                                <input type="text" class="form-control" id="guideline" name="guideline"
                                    value="{{ old('guideline', $mealPlan->guideline) }}">
                            </div>

                            <div class="mb-3">
                                <label for="day" class="form-label">Day</label>
                                <select class="form-control" id="day" name="day">
                                    <option value="Monday" {{ $mealPlan->day == 'Monday' ? 'selected' : '' }}>Monday</option>
                                    <option value="Tuesday" {{ $mealPlan->day == 'Tuesday' ? 'selected' : '' }}>Tuesday
                                    </option>
                                    <option value="Wednesday" {{ $mealPlan->day == 'Wednesday' ? 'selected' : '' }}>Wednesday
                                    </option>
                                    <option value="Thursday" {{ $mealPlan->day == 'Thursday' ? 'selected' : '' }}>Thursday
                                    </option>
                                    <option value="Friday" {{ $mealPlan->day == 'Friday' ? 'selected' : '' }}>Friday</option>
                                    <option value="Saturday" {{ $mealPlan->day == 'Saturday' ? 'selected' : '' }}>Saturday
                                    </option>
                                    <option value="Sunday" {{ $mealPlan->day == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="breakfast" class="form-label">Breakfast</label>
                                <input type="text" class="form-control" id="breakfast" name="breakfast"
                                    value="{{ old('breakfast', $mealPlan->breakfast) }}">
                            </div>

                            <div class="mb-3">
                                <label for="lunch" class="form-label">Lunch</label>
                                <input type="text" class="form-control" id="lunch" name="lunch"
                                    value="{{ old('lunch', $mealPlan->lunch) }}">
                            </div>

                            <div class="mb-3">
                                <label for="dinner" class="form-label">Dinner</label>
                                <input type="text" class="form-control" id="dinner" name="dinner"
                                    value="{{ old('dinner', $mealPlan->dinner) }}">
                            </div>

                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Meal Plan</button>
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