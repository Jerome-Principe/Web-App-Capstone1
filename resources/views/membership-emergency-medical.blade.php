<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{asset('assets/images/muscle.png')}}" type="image/png">
    <title>Emergency Contact / Medical Questionnaire</title>
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

        .main-wrapper {
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

        /* Minimalist Table Styles */
        .table-section h2 {
            font-size: 20px;
            font-weight: 500;
            color: #333;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e1e5e9;
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

        .filter-links a {
            color: #007bff;
            text-decoration: none;
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }

        .filter-links a:hover {
            background: #e3f2fd;
        }

        .filter-links a.active {
            background: #007bff;
            color: white;
        }

        .table-container {
            max-height: 700px;
            overflow-y: auto;
            overflow-x: auto;
            white-space: nowrap;
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
            position: sticky;
            top: 0;
            z-index: 10;
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

        .badge.bg-success {
            background: #28a745 !important;
            color: white;
        }

        .badge.bg-danger {
            background: #dc3545 !important;
            color: white;
        }

        .badge.bg-warning {
            background: #ffc107 !important;
            color: #212529;
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

        /* Responsive */
        @media (max-width: 768px) {
            .main-wrapper {
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

            .filter-links {
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            /* Mobile table responsive design */
            .table-container {
                border: none;
                overflow-x: visible;
                max-height: none;
            }

            table {
                border: none;
                width: 100%;
                table-layout: fixed;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tbody tr {
                border: 1px solid #e1e5e9;
                border-radius: 8px;
                margin-bottom: 16px;
                padding: 16px;
                background: white;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                position: relative;
            }

            tbody tr:hover {
                background: #f8f9fa;
            }

            tbody td {
                border: none;
                padding: 8px 0;
                text-align: left !important;
                position: relative;
                padding-left: 50% !important;
                word-wrap: break-word;
                min-width: auto;
            }

            tbody td:before {
                content: attr(data-label) ": ";
                position: absolute;
                left: 6px;
                width: 45%;
                text-align: left;
                font-weight: 600;
                color: #333;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            /* Hide checkbox column on mobile */
            tbody td:first-child {
                display: none;
            }

            /* Medical form specific mobile styles */
            .badge {
                font-size: 11px;
                padding: 3px 6px;
            }
        }

        /* Fade animations */
        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Text utilities */
        .text-muted {
            color: #6c757d !important;
        }

        .text-success {
            color: #28a745 !important;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Medical Forms</h1>
                <p>Emergency contact and medical questionnaire records</p>
            </div>

            <!-- Medical Forms Section -->
            <div class="content-card">
                <div class="table-section">
                    <h2>Emergency Contact / Medical Questionnaire</h2>

                    <!-- Filter Options Section -->
                    <div class="filter-options">
                        <div class="filter-links">
                            <a href="#" id="select-all-link" class="active">All (0)</a>
                        </div>

                        <div>
                            <!-- Search Form -->
                            <form class="d-flex" role="search" action="#" method="GET">
                                <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                    style="height: 35px;">
                                <button class="btn btn-primary ms-2" type="submit" style="height: 35px;">Search</button>
                            </form>
                        </div>
                    </div>

                    <!-- Medical Forms Table Section -->
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th>ID</th>
                                    <th>Emergency Contact Name</th>
                                    <th>Relationship</th>
                                    <th>Contact Number</th>
                                    <th>Heart Disease</th>
                                    <th>Asthma</th>
                                    <th>Gout</th>
                                    <th>Cardiovascular Condition</th>
                                    <th>High Blood Pressure</th>
                                    <th>Dizziness</th>
                                    <th>Arthritis</th>
                                    <th>Infectious Disease</th>
                                    <th>Black Outs</th>
                                    <th>Diabetes</th>
                                    <th>Fainting</th>
                                    <th>Epilepsy</th>
                                    <th>Other Conditions</th>
                                    <th>Knees</th>
                                    <th>Lower Back</th>
                                    <th>Neck</th>
                                    <th>Shoulders</th>
                                    <th>Hips</th>
                                    <th>Pelvis</th>
                                    <th>Flexibility</th>
                                    <th>Other Injuries</th>
                                    <th>Pregnant</th>
                                    <th>Weeks Pregnant</th>
                                    <th>Physical Activities</th>
                                    <th>Smoking Details</th>
                                    <th>Medication Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($medicalForms as $form)
                                    <tr>
                                        <td data-label="Select">
                                            <input type="checkbox" name="selected[]" value="{{ $form->id }}"
                                                onchange="updateSelectionCount()" />
                                        </td>
                                        <td data-label="ID">
                                            <span class="badge bg-primary">{{ $form->id }}</span>
                                        </td>
                                        <td data-label="Emergency Contact">
                                            <strong>{{ $form->emergency_contact ?? 'N/A' }}</strong>
                                        </td>
                                        <td data-label="Relationship">{{ $form->relationship ?? 'N/A' }}</td>
                                        <td data-label="Contact Number">{{ $form->emergency_number ?? 'N/A' }}</td>
                                        <td data-label="Heart Disease">
                                            <span class="badge {{ $form->heart_disease ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->heart_disease ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Asthma">
                                            <span class="badge {{ $form->asthma ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->asthma ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Gout">
                                            <span class="badge {{ $form->gout ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->gout ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Cardiovascular">
                                            <span
                                                class="badge {{ $form->cardiovascular_condition ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->cardiovascular_condition ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="High Blood Pressure">
                                            <span class="badge {{ $form->high_blood_pressure ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->high_blood_pressure ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Dizziness">
                                            <span class="badge {{ $form->dizziness ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->dizziness ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Arthritis">
                                            <span class="badge {{ $form->arthritis ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->arthritis ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Infectious Disease">
                                            <span class="badge {{ $form->infectious_disease ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->infectious_disease ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Black Outs">
                                            <span class="badge {{ $form->black_outs ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->black_outs ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Diabetes">
                                            <span class="badge {{ $form->diabetes ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->diabetes ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Fainting">
                                            <span class="badge {{ $form->fainting ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->fainting ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Epilepsy">
                                            <span class="badge {{ $form->epilepsy ? 'bg-danger' : 'bg-success' }}">
                                                {{ $form->epilepsy ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Other Conditions">{{ $form->other_condition1 ?? 'N/A' }}</td>
                                        <td data-label="Knees">
                                            <span class="badge {{ $form->knees ? 'bg-warning' : 'bg-success' }}">
                                                {{ $form->knees ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Lower Back">
                                            <span class="badge {{ $form->lower_back ? 'bg-warning' : 'bg-success' }}">
                                                {{ $form->lower_back ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Neck">
                                            <span class="badge {{ $form->neck ? 'bg-warning' : 'bg-success' }}">
                                                {{ $form->neck ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Shoulders">
                                            <span class="badge {{ $form->shoulders ? 'bg-warning' : 'bg-success' }}">
                                                {{ $form->shoulders ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Hips">
                                            <span class="badge {{ $form->hips ? 'bg-warning' : 'bg-success' }}">
                                                {{ $form->hips ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Pelvis">
                                            <span class="badge {{ $form->pelvis ? 'bg-warning' : 'bg-success' }}">
                                                {{ $form->pelvis ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Flexibility">
                                            <span class="badge {{ $form->flexibility ? 'bg-warning' : 'bg-success' }}">
                                                {{ $form->flexibility ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Other Injuries">{{ $form->other_condition2 ?? 'N/A' }}</td>
                                        <td data-label="Pregnant">
                                            <span class="badge {{ $form->pregnant ? 'bg-warning' : 'bg-success' }}">
                                                {{ $form->pregnant ?? 'No' }}
                                            </span>
                                        </td>
                                        <td data-label="Weeks Pregnant">{{ $form->weeks_pregnant ?? 'N/A' }}</td>
                                        <td data-label="Physical Activities">{{ $form->physical_activities ?? 'N/A' }}</td>
                                        <td data-label="Smoking Details">{{ $form->smoke_details ?? 'N/A' }}</td>
                                        <td data-label="Medication Details">{{ $form->medication_details ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="33">
                                            <div class="empty-state">
                                                <i class="fa fa-heartbeat"></i>
                                                <h5>No medical forms found</h5>
                                                <p>There are no medical questionnaire records to display</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if($medicalForms->hasPages())
                            <!-- Pagination Section -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $medicalForms->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $medicalForms->previousPageUrl() }}">
                                            Previous
                                        </a>
                                    </li>

                                    @foreach(range(1, $medicalForms->lastPage()) as $page)
                                        <li class="page-item {{ $page == $medicalForms->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $medicalForms->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <li class="page-item {{ !$medicalForms->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $medicalForms->nextPageUrl() }}">
                                            Next
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Function to toggle select all checkboxes
            function toggleSelectAll(source) {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = source.checked;
                });
                updateSelectionCount();
            }

            // Function to update the selection count
            function updateSelectionCount() {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
                const count = checkboxes.length;
                const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

                updateSelectAllLabel(count, totalCount);

                // Update select all checkbox
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = count === totalCount && totalCount > 0;
                selectAllCheckbox.indeterminate = count > 0 && count < totalCount;
            }

            // Update the "All" link label to show the number of selected items
            function updateSelectAllLabel(count, totalCount) {
                const selectAllLink = document.getElementById('select-all-link');
                selectAllLink.innerText = `All (${count}/${totalCount})`;
            }

            // Add functionality for the "All" link click
            document.getElementById('select-all-link').addEventListener('click', function (e) {
                e.preventDefault();
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
                toggleSelectAll(selectAllCheckbox);
            });

            // Initialize selection count on page load
            document.addEventListener("DOMContentLoaded", function () {
                updateSelectionCount();
            });
        </script>

    </body>
@endsection