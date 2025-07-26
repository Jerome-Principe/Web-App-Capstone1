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
            margin: 30px auto;
            background-color: white;
            padding: 40px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            border: 1px solid #e1e5e9;
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
            text-align: center;
            border-bottom: 1px solid #e1e5e9;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            text-align: center;
            vertical-align: middle;
        }

        /* Hover effect */
        tbody tr:hover {
            background: #f8f9fa;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #007bff;
        }

        .date-info {
            font-size: 12px;
            color: gray;
        }

        .modal {
            z-index: 1055;
        }

        /* No Data Message Styling */
        .no-data-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .no-data-message i {
            display: block;
            margin-bottom: 16px;
        }

        .no-data-message h4 {
            margin-bottom: 8px;
            font-size: 18px;
        }

        .no-data-message p {
            font-size: 14px;
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
                    <a href="{{ route('instructors.trashed') }}">Archived
                        ({{ App\Models\Instructor::onlyTrashed()->count() }})
                    </a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <form action="{{ route('instructors.moveToTrash') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2">
                                <i class="fa fa-trash"></i> Move to Archive
                            </button>
                        </form>
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
                <table>
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                            <th class="text-center">ID</th>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Contact Number</th>
                            <th class="text-center">Expertise</th>
                            <th class="text-center">Session</th>
                            <th class="text-center">Rates</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($instructors->count() > 0)
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
                                    <td class="text-center">{{ $instructor->contact_number }}</td>
                                    <td class="text-center">{{ $instructor->expertise ?? 'N/A' }}</td>
                                    <td class="text-center">{{ $instructor->session }}</td>
                                    <td class="text-center">₱{{ number_format($instructor->rates, 2) }}</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editInstructorModal{{ $instructor->id }}">Update
                                        </button>
                                        <form action="{{ route('instructors.destroy', $instructor->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this instructor?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="no-data-message">
                                        <i class="fa fa-users" style="font-size: 48px; color: #ccc; margin-bottom: 16px;"></i>
                                        <h4 style="color: #666; font-weight: bold; margin-bottom: 8px;">No instructors found</h4>
                                        <p style="color: #999; margin: 0;">There are no instructors to display</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
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
                    <div class="modal-body">
                        <form action="{{ route('instructors.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact_number">Contact Number</label>
                                <input type="text" name="contact_number" id="contact_number" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="expertise">Expertise</label>
                                <input type="text" name="expertise" id="expertise" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="session">Session</label>
                                <input type="text" name="session" id="session" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="rates">Rates</label>
                                <input type="number" step="0.01" name="rates" id="rates" class="form-control">
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Instructor</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Instructor -->
        @foreach($instructors as $instructor)
            <div class="modal fade" id="editInstructorModal{{ $instructor->id }}" tabindex="-1"
                aria-labelledby="editInstructorModalLabel{{ $instructor->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editInstructorModalLabel">Edit Instructor</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('instructors.update', $instructor->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <!-- Form fields -->

                                <input type="hidden" name="id" value="{{ $instructor->id }}">
                                <div class="mb-3">
                                    <label for="edit_first_name" class="form-label">First Name</label>
                                    <input type="text" name="first_name" id="edit_first_name" class="form-control"
                                        value="{{ $instructor->first_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_last_name" class="form-label">Last Name</label>
                                    <input type="text" name="last_name" id="edit_last_name" class="form-control"
                                        value="{{ $instructor->last_name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_contact_number" class="form-label">Contact Number</label>
                                    <input type="text" name="contact_number" id="edit_contact_number" class="form-control"
                                        value="{{ $instructor->contact_number }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_expertise" class="form-label">Expertise</label>
                                    <input type="text" name="expertise" id="edit_expertise" class="form-control"
                                        value="{{ $instructor->expertise }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_session" class="form-label">Expertise</label>
                                    <input type="text" name="session" id="edit_session" class="form-control"
                                        value="{{ $instructor->session }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_rates" class="form-label">Rates</label>
                                    <input type="text" name="rates" id="edit_rates" class="form-control"
                                        value="{{ $instructor->rates }}" required>
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
        // Add the toggleSelectAll function
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            checkboxes.forEach(function (item) {
                item.checked = checkbox.checked;
            });
            updateSelectionCount();
        }

        // Update the selection count when checkboxes are toggled
        function updateSelectionCount() {
            const selectedCheckboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const count = selectedCheckboxes.length;

            // Update the "All (count)" link text
            const allLink = document.getElementById('select-all-link');
            allLink.textContent = `All (${count})`;

            // Update the selected IDs field to be submitted with the form
            const selectedIds = Array.from(selectedCheckboxes).map(input => input.value);
            document.getElementById('selectedIds').value = selectedIds.join(',');
        }

        // Add the event listener for the "All (0)" link click
        document.getElementById('select-all-link').addEventListener('click', function (e) {
            e.preventDefault(); // Prevent the default link behavior
            const isChecked = this.textContent.includes('0') || this.textContent.includes('All (0)');

            // Toggle the "Select All" checkbox and update the count
            const selectAllCheckbox = document.querySelector('input[type="checkbox"]');
            selectAllCheckbox.checked = isChecked;
            toggleSelectAll(selectAllCheckbox);
        });

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