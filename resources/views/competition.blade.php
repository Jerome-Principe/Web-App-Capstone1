<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <title>Competition Form Records</title>
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
            overflow-x: auto;
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

        input[type="checkbox"] {
            margin: 0;
        }
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Gym Competition Record List</h1>
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

            <div class="filter-options">
                <div class="filter-links">
                    <!-- Link to view all -->
                    <a href="#" id="select-all-link">All (0)</a>

                    <!-- Link to view all trashed announcements -->
                    <a href="#" id="select-all-link">Archived (0)</a>

                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <form action="#" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2">
                                <i class="fa fa-trash"></i> Move to Trash
                            </button>
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
                            <th class="text-center">Name</th>
                            <th class="text-center">Age</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Height (cm)</th>
                            <th class="text-center">Weight (kg)</th>
                            <th class="text-center">Type of Competition</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($competitions as $index => $competition)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $competition->id }}"
                                        onchange="updateSelectionCount()" /></td>
                                <td class="text-center">{{ $competition->id }}</td>
                                <td class="text-center">{{ $competition->name}}</td>
                                <td class="text-center">{{ $competition->age }}</td>
                                <td class="text-center">{{ $competition->gender }}</td>
                                <td class="text-center">{{ $competition->height }}</td>
                                <td class="text-center">{{ $competition->weight }}</td>
                                <td class="text-center">{{ $competition->type_of_competition }}</td>
                                <td class="d-flex justify-content-center">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#editCompetitionModal" data-id="{{ $competition->id }}"
                                        data-name="{{ $competition->name }}" data-age="{{ $competition->age }}"
                                        data-gender="{{ $competition->gender }}" data-height="{{ $competition->height }}"
                                        data-weight="{{ $competition->weight }}"
                                        data-activity="{{ $competition->type_of_competition }}">
                                        <i class="fa fa-pencil-square-o mx-1"></i>Update
                                    </button>

                                    <form action="{{ route('competitions.destroy', $competition->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-1"
                                            onclick="return confirm('Are you sure you want to delete this competition record?')">
                                            <i class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination links -->
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item {{ $competitions->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $competitions->previousPageUrl() }}">Previous</a>
                        </li>

                        @foreach ($competitions->getUrlRange(1, $competitions->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $competitions->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$competitions->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $competitions->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Edit Goal Modal -->
        <div class="modal fade" id="editCompetitionModal" tabindex="-1" aria-labelledby="editCompetitionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <form method="POST" id="editCompetitionForm" action="">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Competition</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="competition_id" id="competition_id">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Age</label>
                                <input type="number" name="age" id="edit_age" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Gender</label>
                                <input type="text" name="gender" id="edit_gender" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Height (cm)</label>
                                <input type="number" name="height" id="edit_height" class="form-control" step="0.01">
                            </div>
                            <div class="mb-3">
                                <label>Weight (kg)</label>
                                <input type="text" name="weight" id="edit_weight" class="form-control" step="0.01">
                            </div>
                            <div class="mb-3">
                                <label>Type of Competition</label>
                                <select name="type_of_competition" id="edit_competition" class="form-control">
                                    <option value="" disabled selected>-- Select Activity Level --</option>
                                    <option value="Powerlifting">Powerlifting</option>
                                    <option value="Boxing">Boxing</option>
                                    <option value="Crossfit">Crossfit</option>
                                    <option value="Body building">Body building</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update Goal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <script>
            const editModal = document.getElementById('editCompetitionModal');
            editModal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const age = button.getAttribute('data-age');
                const gender = button.getAttribute('data-gender');
                const height = button.getAttribute('data-height');
                const weight = button.getAttribute('data-weight');
                const activity = button.getAttribute('data-activity');

                document.getElementById('competition_id').value = id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_age').value = age;
                document.getElementById('edit_gender').value = gender;
                document.getElementById('edit_height').value = height;
                document.getElementById('edit_weight').value = weight;

                const activitySelect = document.getElementById('edit_competition');
                if (activitySelect) {
                    [...activitySelect.options].forEach(option => {
                        option.selected = option.value === activity;
                    });
                }

                const form = document.getElementById('editCompetitionForm');
                form.action = `/competitions/${id}`;
            });


            // Select all checkboxes
            function toggleSelectAll(source) {
                const checkboxes = document.getElementsByName('selected[]');
                for (let i = 0; i < checkboxes.length; i++) {
                    checkboxes[i].checked = source.checked;
                }
                updateSelectionCount();
            }

            // Update the selection count
            function updateSelectionCount() {
                const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
                const count = checkboxes.length;
                document.getElementById('select-all-link').innerText = `All (${count})`;
            }
        </script>

    </body>

    </html>
@endsection