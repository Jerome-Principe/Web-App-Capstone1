<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Register RFID</title>
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

        /* Hover effect */
        tbody tr:hover {
            background-color: #eaeaea;
            cursor: pointer;
        }

        input[type="checkbox"] {
            margin: 0;
        }

        .summary {
            margin-top: 20px;
        }
    </style>
</head>
@extends('layouts.master')

@section('content')

    <body>
        <div class="container">
            <div class="header-section">
                <h1>Register RFID</h1>

                <div>
                    <div class="d-flex justify-content-end position-relative mx-2">
                        <button class="btn btn-primary px-2" data-bs-toggle="modal" data-bs-target="#addNewModal"><i
                                class="fa fa-plus mx-1" aria-hidden="true"></i>Add New
                        </button>
                    </div>
                </div>

                <div class="d-flex justify-content-end position-relative mx-2">
                    <!-- Flash Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="margin-bottom: 15px; min-width: 200px;">
                            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert"
                            style="margin-bottom: 15px; min-width: 200px;">
                            <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <script>
                        setTimeout(function () {
                            const alerts = document.querySelectorAll('.alert-dismissible');
                            alerts.forEach(alert => {
                                alert.classList.remove('show'); // Hides the alert with Bootstrap's fade-out effect
                                alert.addEventListener('transitionend', () => alert.remove()); // Removes from DOM after fade-out
                            });
                        }, 3000); // 3000 milliseconds = 3 seconds
                    </script>
                </div>

            </div>

            <!-- Add Modal -->
            <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addNewModalLabel">Add New RFID</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('register-rfid.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="id" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="id" id="id" readonly required>
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <select class="form-select" name="username" id="username" required>
                                        <option value="">Select Username</option>
                                        @foreach($approvedMembers as $member)
                                            <option value="{{ $member->first_name }} {{ $member->last_name }}"
                                                data-id="{{ $member->id }}" data-email="{{ $member->email }}">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="serial_number" class="form-label">Serial Number</label>
                                    <input type="text" class="form-control" name="serial_number" required>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" readonly required>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Modal -->
            @foreach($registerRfids as $index => $registerRfid)
                <div class="modal fade" id="updateModal{{ $registerRfid->id }}" tabindex="-1"
                    aria-labelledby="updateModalLabel{{ $registerRfid->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateModalLabel{{ $registerRfid->id }}">Update RFID</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('register-rfid.update', $registerRfid->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="id" class="form-label">ID</label>
                                        <input type="text" class="form-control" name="id" value="{{ $registerRfid->id }}"
                                            readonly required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" name="username"
                                            value="{{ $registerRfid->username }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="serial_number" class="form-label">Serial Number</label>
                                        <input type="text" class="form-control" name="serial_number"
                                            value="{{ $registerRfid->serial_number }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ $registerRfid->email }}"
                                            readonly required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="filter-options">
                <div class="filter-links">
                    <a href="#" id="select-all-link">All (0)</a>
                    <a href="#">Archived</a>
                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <!-- Form to move selected walkins to trash -->
                        <form action="#" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2">
                                <i class="fa fa-trash"></i> Move to Archive
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
                            <th class="text-center">username</th>
                            <th class="text-center">Serial Number</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registerRfids as $index => $registerRfid)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $registerRfid->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">{{ $registerRfid->id }}</td>
                                <td class="text-center">{{ $registerRfid->username }}</td>
                                <td class="text-center">{{ $registerRfid->serial_number }}</td>
                                <td class="text-center">{{ $registerRfid->email }}</td>
                                <td class="d-flex justify-content-center">

                                    <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#updateModal{{ $registerRfid->id }}">
                                        <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                    </a>

                                    <form action="{{ route('register-rfid.destroy', $registerRfid->id) }}" method="POST"
                                        style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mx-1"
                                            onclick="return confirm('Are you sure you want to delete this walk-in client?')"><i
                                                class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item {{ $registerRfids->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $registerRfids->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $registerRfids->lastPage()) as $page)
                            <li class="page-item {{ $page == $registerRfids->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $registerRfids->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$registerRfids->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $registerRfids->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>
    </body>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const usernameSelect = document.getElementById('username');
            const idInput = document.getElementById('id');
            const emailInput = document.getElementById('email');

            usernameSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const id = selectedOption.getAttribute('data-id');
                const email = selectedOption.getAttribute('data-email');

                idInput.value = id ? id : '';
                emailInput.value = email ? email : '';
            });

            const serialInput = document.querySelector('input[name="serial_number"]');

            // Automatically focus the serial number input when the page loads
            serialInput.focus();

            // Listen for input event to capture the scanned value
            serialInput.addEventListener('input', function () {
                // Get the current value of the input
                const scannedValue = serialInput.value;

                // Check if the value length is adequate (e.g., barcode length)
                if (scannedValue.length > 0) {
                    console.log("Scanned Value: " + scannedValue);
                    // Do something with the scanned value, like sending it to the server or processing it
                }
            });

            // Prevent form submission when scanning
            serialInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                }
            });

            // Automatically focus the serial number input when any key is pressed
            document.addEventListener('keydown', function () {
                if (document.activeElement !== serialInput) {
                    serialInput.focus();
                }
            });
        });

    </script>


@endsection