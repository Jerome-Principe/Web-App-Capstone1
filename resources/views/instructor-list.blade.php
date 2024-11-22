<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Instructor List</title>
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
            <h1>Instructor List</h1>
            <!-- Button to trigger modal -->
            <div>
                <div class="d-flex justify-content-end position-relative">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addInstructorModal"><i class="fa fa-plus mx-1" aria-hidden="true"></i>
                        Add New Instructor
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

        <!-- Instructor List Table -->
        <div class="table-container">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                        <th class="text-center">ID</th>
                        <th class="text-center">First Name</th>
                        <th class="text-center">Last Name</th>
                        <th class="text-center">Expertise</th>
                        <th class="text-center">Rates</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($instructors as $instructor)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $instructor->id }}"
                                    onchange="updateSelectionCount()" />
                            </td>
                            <td class="text-center">
                                {{ ($instructors->currentPage() - 1) * $instructors->perPage() + $loop->index + 1 }}
                            </td>
                            <td class="text-center">{{ $instructor->first_name }}</td>
                            <td class="text-center">{{ $instructor->last_name }}</td>
                            <td class="text-center">{{ $instructor->expertise ?? 'N/A' }}</td>
                            <td class="text-center">₱{{ number_format($instructor->rates, 2) }}</td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mt-4 mb-4">
                    <li class="page-item {{ $instructors->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $instructors->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>

                    @foreach(range(1, $instructors->lastPage()) as $page)
                        <li class="page-item {{ $page == $instructors->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $instructors->url($page) }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ !$instructors->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $instructors->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

    <!-- Add Instructor Modal -->
    <div class="modal fade" id="addInstructorModal" tabindex="-1" aria-labelledby="addInstructorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addInstructorModalLabel">Add New Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('instructors.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="expertise">Expertise</label>
                            <input type="text" name="expertise" id="expertise" class="form-control">
                        </div>
                        <div class="form-group mb-2">
                            <label for="rates">Rates</label>
                            <input type="number" step="0.01" name="rates" id="rates" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Instructor</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalElement = document.getElementById('addInstructorModal');
        if (modalElement) {
            new bootstrap.Modal(modalElement);
        }
    });
</script>

@endsection