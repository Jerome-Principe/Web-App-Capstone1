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
            width: 100%;
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
            overflow: visible;
        }

        /* Actions column specific styling */
        td:last-child {
            min-width: 150px;
            white-space: nowrap;
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

        /* Ensure buttons are visible */
        .btn-sm {
            font-size: 12px;
            padding: 4px 8px;
            min-width: auto;
        }

        /* Action column styling */
        .table td:last-child {
            min-width: 140px;
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
            <div class="content-card">
                <div class="header-section">
                    <div class="d-flex align-items-center">
                        <h1 class="mb-0 me-3">Meal Plan Default List</h1>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addMealPlanModal"><i class="fa fa-plus mx-1" aria-hidden="true"></i>
                            Add New Meal Plan
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
                            @if($mealPlans->count() > 0)
                                @foreach($mealPlans as $mealPlan)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="selected[]" value="{{ $mealPlan->id }}" />
                                        </td>
                                        <td class="text-center">{{ $mealPlan->id }}</td>
                                        <td class="text-center">{{ $mealPlan->category }}</td>
                                        <td class="text-center">{{ $mealPlan->type }}</td>
                                        <td class="text-center">{{ $mealPlan->guideline }}</td>
                                        <td class="text-center">{{ $mealPlan->day }}</td>
                                        <td class="text-center">{{ $mealPlan->breakfast }}</td>
                                        <td class="text-center">{{ $mealPlan->lunch }}</td>
                                        <td class="text-center">{{ $mealPlan->dinner }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editMealPlanModal{{ $mealPlan->id }}"
                                                    style="white-space: nowrap;">
                                                    <i class="fa fa-pencil-square-o me-1" aria-hidden="true"></i>Update
                                                </button>

                                                <!-- Delete Button (Form for DELETE request) -->
                                                <form action="{{ route('meal-plan.destroy', $mealPlan->id) }}" method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" style="white-space: nowrap;"
                                                        onclick="return confirm('Are you sure you want to delete this meal plan?')">
                                                        <i class="fa fa-trash-o me-1" aria-hidden="true"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <!-- No Data State -->
                                <tr>
                                    <td colspan="10" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-users"
                                                style="font-size: 64px; color: #6c757d; margin-bottom: 20px; display: block;"></i>
                                            <h4 class="text-dark mb-2">No meal plans found</h4>
                                            <p class="text-muted">There are no meal plan records to display.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    @if($mealPlans->count() > 0)
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
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal for Adding Meal Plan -->
        <div class="modal fade" id="addMealPlanModal" tabindex="-1" aria-labelledby="addMealPlanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMealPlanModalLabel">Add New Meal Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                        <form action="{{ route('meal-plan.store') }}" method="POST" id="mealPlanForm">
                            @csrf

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

                            <div class="mb-3">
                                <label for="guideline" class="form-label">Guideline</label>
                                <textarea class="form-control" id="guideline" name="guideline"
                                    placeholder="Enter guidelines..." required
                                    style="height: 80px; resize: none;"></textarea>
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
                                <label for="breakfast" class="form-label">Breakfast</label>
                                <textarea class="form-control" id="breakfast" name="breakfast"
                                    placeholder="Enter breakfast details..." required
                                    style="height: 80px; resize: none;"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="lunch" class="form-label">Lunch</label>
                                <textarea class="form-control" id="lunch" name="lunch" placeholder="Enter lunch details..."
                                    required style="height: 80px; resize: none;"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="dinner" class="form-label">Dinner</label>
                                <textarea class="form-control" id="dinner" name="dinner"
                                    placeholder="Enter dinner details..." required
                                    style="height: 80px; resize: none;"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" form="mealPlanForm" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Meal Plan -->
        @foreach($mealPlans as $mealPlan)
            <div class="modal fade" id="editMealPlanModal{{ $mealPlan->id }}" tabindex="-1"
                aria-labelledby="editMealPlanModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editMealPlanModalLabel">Edit Meal Plan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('meal-plan.update', $mealPlan->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category" name="category"
                                        value="Meal Plan Guide" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="type{{ $mealPlan->id }}" class="form-label">Type</label>
                                    <select class="form-control" id="type{{ $mealPlan->id }}" name="type" required>
                                        @foreach(['WEIGHT LOSS', 'BUILD MUSCLE', 'GAIN WEIGHT', 'BUILD ENDURANCE', 'LOSS WEIGHT & BUILD MUSCLE', 'STRENGTH & CONDITIONING', 'HIGH INTENSITY TRAINING', 'ATHLETIC TRAINING', 'CIRCUIT CROSSFIT', 'WEIGHT TRAINING', 'BODY BUILDING', 'AEROBOXING', 'KICK BOXING', 'TAEKWONDO', 'BOXING', 'CARDIO', 'WEIGHT LIFTING', 'ZUMBA', 'YOGA', 'POLE DANCING'] as $type)
                                            <option value="{{ $type }}" {{ $mealPlan->type == $type ? 'selected' : '' }}>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Accordion for Details -->
                                <div class="accordion" id="editMealPlanAccordion{{ $mealPlan->id }}">
                                    <!-- General Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingDetails{{ $mealPlan->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseDetails{{ $mealPlan->id }}" aria-expanded="true"
                                                aria-controls="editCollapseDetails{{ $mealPlan->id }}">
                                                General Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseDetails{{ $mealPlan->id }}"
                                            class="accordion-collapse collapse show"
                                            aria-labelledby="editHeadingDetails{{ $mealPlan->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="guideline{{ $mealPlan->id }}"
                                                        class="form-label">Guideline</label>
                                                    <textarea class="form-control" id="guideline{{ $mealPlan->id }}"
                                                        name="guideline"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $mealPlan->guideline }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="day{{ $mealPlan->id }}" class="form-label">Day</label>
                                                    <select class="form-control" id="day{{ $mealPlan->id }}" name="day">
                                                        <option value="Monday" {{ $mealPlan->day == 'Monday' ? 'selected' : '' }}>
                                                            Monday</option>
                                                        <option value="Tuesday" {{ $mealPlan->day == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                                        <option value="Wednesday" {{ $mealPlan->day == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                                        <option value="Thursday" {{ $mealPlan->day == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                                        <option value="Friday" {{ $mealPlan->day == 'Friday' ? 'selected' : '' }}>
                                                            Friday</option>
                                                        <option value="Saturday" {{ $mealPlan->day == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                                        <option value="Sunday" {{ $mealPlan->day == 'Sunday' ? 'selected' : '' }}>
                                                            Sunday</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Meal Details -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="editHeadingMeals{{ $mealPlan->id }}">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#editCollapseMeals{{ $mealPlan->id }}" aria-expanded="true"
                                                aria-controls="editCollapseMeals{{ $mealPlan->id }}">
                                                Meal Details
                                            </button>
                                        </h2>
                                        <div id="editCollapseMeals{{ $mealPlan->id }}" class="accordion-collapse collapse show"
                                            aria-labelledby="editHeadingMeals{{ $mealPlan->id }}">
                                            <div class="accordion-body">
                                                <div class="mb-3">
                                                    <label for="breakfast{{ $mealPlan->id }}"
                                                        class="form-label">Breakfast</label>
                                                    <textarea class="form-control" id="breakfast{{ $mealPlan->id }}"
                                                        name="breakfast"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $mealPlan->breakfast }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="lunch{{ $mealPlan->id }}" class="form-label">Lunch</label>
                                                    <textarea class="form-control" id="lunch{{ $mealPlan->id }}" name="lunch"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $mealPlan->lunch }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dinner{{ $mealPlan->id }}" class="form-label">Dinner</label>
                                                    <textarea class="form-control" id="dinner{{ $mealPlan->id }}" name="dinner"
                                                        style="height: 100px; resize: none; white-space: pre-wrap;">{{ $mealPlan->dinner }}</textarea>
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

        // Simple modal and form handling
        document.addEventListener('DOMContentLoaded', function () {
            const addMealPlanModal = document.getElementById('addMealPlanModal');
            const mealPlanForm = document.getElementById('mealPlanForm');

            if (addMealPlanModal) {
                // Reset form when modal is hidden
                addMealPlanModal.addEventListener('hidden.bs.modal', function () {
                    if (mealPlanForm) {
                        mealPlanForm.reset();
                    }
                });
            }

            // Simple form validation
            if (mealPlanForm) {
                mealPlanForm.addEventListener('submit', function (e) {
                    const requiredFields = mealPlanForm.querySelectorAll('[required]');
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