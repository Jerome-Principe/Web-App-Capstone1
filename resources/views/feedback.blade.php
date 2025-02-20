<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Feedback</title>
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
    </style>
</head>

@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Feedback Data</h1>

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
                    <a href="{{ route('feedback.trashed') }}">Trashed
                        ({{ App\Models\Feedback::onlyTrashed()->count() }})
                    </a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Form to move selected feedback to trash -->
                        <form action="{{ route('feedback.moveToTrash') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2">
                                <i class="fa fa-trash"></i> Move to Trash
                            </button>
                        </form>

                        <!-- Search Form -->
                        <form class="d-flex" role="search" action="#" method="GET">
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
                            <th class="text-center">Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Subject</th>
                            <th class="text-center">Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($feedback as $index => $feedbacks)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $feedbacks->id }}"
                                        onchange="updateSelectionCount()" /></td>
                                <td class="text-center">{{ $feedbacks->id }}</td>
                                <td class="text-center">{{ $feedbacks->name }}</td>
                                <td class="text-center">{{ $feedbacks->email }}</td>
                                <td class="text-center">{{ $feedbacks->subject }}</td>
                                <td class="text-center">{{ $feedbacks->message }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item {{ $feedback->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $feedback->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach ($feedback->getUrlRange(1, $feedback->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $feedback->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$feedback->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $feedback->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </body>

    <script>
        // Toggle select all checkboxes
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            checkboxes.forEach(item => item.checked = checkbox.checked);
            updateSelectionCount();
        }

        // Update selected count and hidden input value
        function updateSelectionCount() {
            const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const count = selectedCheckboxes.length;
            document.getElementById('select-all-link').textContent = `All (${count})`;
            const selectedIds = Array.from(selectedCheckboxes).map(input => input.value);
            document.getElementById('selectedIds').value = selectedIds.join(',');
            console.log(selectedIds.join(',')); // Log selected IDs to debug
        }

        // Add functionality for the "All (0)" link click
        document.getElementById('select-all-link').addEventListener('click', function (e) {
            e.preventDefault();
            const isChecked = this.textContent.includes('0') || this.textContent.includes('All (0)');
            const selectAllCheckbox = document.querySelector('input[type="checkbox"]');
            selectAllCheckbox.checked = isChecked;
            toggleSelectAll(selectAllCheckbox);
        });

        // Ensure the form doesn't submit if no appointments are selected
        document.getElementById('restore-selected-form').addEventListener('submit', function (e) {
            const selectedIds = document.getElementById('selectedIds').value;
            if (!selectedIds) {
                alert('Please select at least one appointments to restore.');
                e.preventDefault(); // Prevent form submission
            }
        });
    </script>

    </html>

@endsection