<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Emergency Contact / Medical Questionnaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            background-color: #f8f9fc;
            /* Light background */
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
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
            background-color: transparent;
        }

        th {
            font-weight: bold;
            border-bottom: 1px solid #999;
            padding: 12px 10px;
            text-align: center;
            background-color: transparent !important;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            text-align: center;
        }

        /* Hover effect */
        tbody tr:hover {
            background-color: #eaeaea;
            cursor: pointer;
        }

        input[type="checkbox"] {
            margin: 0;
        }

        .date-info {
            font-size: 12px;
            color: gray;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Emergency Contact / Medical Questionnaire</h1>
            </div>

            <div class="d-flex justify-content-end mb-3">
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                        style="width: 250px; height: 35px;">
                    <button class="btn btn-primary" type="submit" style="height: 35px;">Search</button>
                </form>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Emergency Contact Name</th>
                            <th class="text-center">Relationship</th>
                            <th class="text-center">Contact Number</th>
                            <th class="text-center">Heart Disease</th>
                            <th class="text-center">Asthma</th>
                            <th class="text-center">Gout</th>
                            <th class="text-center">Cardiovascular Condition</th>
                            <th class="text-center">High Blood Pressure</th>
                            <th class="text-center">Dizziness</th>
                            <th class="text-center">Athritis</th>
                            <th class="text-center">Infectious Disease</th>
                            <th class="text-center">Black Outs</th>
                            <th class="text-center">Diabetes</th>
                            <th class="text-center">Fainting</th>
                            <th class="text-center">Epilepsy</th>
                            <th class="text-center">Others:</th>
                            <th class="text-center">Knees</th>
                            <th class="text-center">Lower Back</th>
                            <th class="text-center">Kneck</th>
                            <th class="text-center">Shoulders</th>
                            <th class="text-center">Hips</th>
                            <th class="text-center">Pelvis</th>
                            <th class="text-center">Flexibility</th>
                            <th class="text-center">Others:</th>
                            <th class="text-center">Are you Pregnant?</th>
                            <th class="text-center">If YES, how many weeks?</th>
                            <th class="text-center">
                                Are you currently doing any regular physical activities? What and how
                                how many times per weeks?
                            </th>
                            <th class="text-center">
                                Do you smoke, if yes how many per day? and for how long have you smoked?
                            </th>
                            <th class="text-center">Are you on medication? If yes, what and whendo you take?</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($medicalForms as $form)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $form->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">{{ $form->id }}</td>
                                <td class="text-center">{{ $form->emergency_contact }}</td>
                                <td class="text-center">{{ $form->relationship }}</td>
                                <td class="text-center">{{ $form->emergency_number }}</td>
                                <td class="text-center">{{ $form->heart_disease ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->asthma ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->gout ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->cardiovascular_condition ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->high_blood_pressure ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->dizziness ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->arthritis ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->infectious_disease ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->black_outs ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->diabetes ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->fainting ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->epilepsy ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->other_condition1 }}</td>
                                <td class="text-center">{{ $form->knees ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->lower_back ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->neck ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->shoulders ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->hips ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->pelvis ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->flexibility ? 'Yes' : 'No' }}</td>
                                <td class="text-center">{{ $form->other_condition2 }}</td>
                                <td class="text-center">{{ $form->pregnant }}</td>
                                <td class="text-center">{{ $form->weeks_pregnant }}</td>
                                <td class="text-center">{{ $form->physical_activities }}</td>
                                <td class="text-center">{{ $form->smoke_details }}</td>
                                <td class="text-center">{{ $form->medication_details }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4 mb-4">
                        <li class="page-item {{ $medicalForms->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $medicalForms->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $medicalForms->lastPage()) as $page)
                            <li class="page-item {{ $page == $medicalForms->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{$medicalForms->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$medicalForms->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $medicalForms->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>

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

    </body>
@endsection