<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{asset('assets/images/muscle.png')}}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Register RFID</title>
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

        .container {
            max-width: 1000px;
            margin: 30px auto;
            background-color: #f8f9fc;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
            border: 1px solid #e1e5e9;
        }

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
            margin-right: 15px;
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
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
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
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
            text-align: center !important;
        }

        /* Ensure all content inside cells is centered */
        td *,
        th * {
            text-align: center !important;
        }

        /* Center flex containers */
        td .d-flex,
        th .d-flex {
            justify-content: center !important;
            align-items: center !important;
        }

        /* Center button groups */
        td .action-buttons {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            gap: 8px;
        }

        /* Perfect centering for checkboxes */
        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #007bff;
            margin: 0 auto;
            display: block;
        }

        /* Button Group Styling to match admin users page */
        .btn-group .btn {
            margin-right: 5px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Ensure consistent button sizing and spacing */
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
        }

        /* Outline button hover effects */
        .btn-outline-primary:hover {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-outline-danger:hover {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }

        tbody tr:hover {
            background: #f8f9fa;
            cursor: pointer;
        }

        input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #007bff;
        }

        .summary {
            margin-top: 20px;
        }

        /* Minimalist Button Styles */
        .btn {
            border-radius: 4px;
            padding: 10px 20px;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: #007bff;
            color: white;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background: #545b62;
            border-color: #545b62;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
            border-color: #c82333;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
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

        /* Minimalist Modal */
        .modal-content {
            border-radius: 8px;
            border: 1px solid #e1e5e9;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e1e5e9;
            border-radius: 8px 8px 0 0;
        }

        .modal-title {
            font-weight: 500;
            color: #333;
        }

        /* Minimalist Alert */
        .alert {
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 14px;
            margin-bottom: 15px;
            min-width: 200px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

        /* Clock Styles */
        .clock {
            font-size: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            margin: 0 auto 20px auto;
            border-radius: 12px;
            text-align: center;
            width: fit-content;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            font-weight: 600;
            letter-spacing: 2px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-wrapper {
                padding: 20px 16px;
            }

            .content-card {
                padding: 24px 16px;
            }

            .container {
                padding: 16px;
                margin: 15px auto;
            }

            .filter-options {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .filter-links {
                justify-content: center;
            }
        }
    </style>
</head>
@extends('layouts.master')

@section('content')

    <body>
        <div class="main-wrapper">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Register RFID</h1>
                <p>Manage RFID card registrations for member access</p>
            </div>

            <div class="content-card">
                <div class="header-section">
                    <h1>Register RFID</h1>

                    <div>
                        <div class="d-flex justify-content-end position-relative mx-2">
                            <button class="btn btn-outline-primary px-2" data-bs-toggle="modal"
                                data-bs-target="#addNewModal"><i class="fa fa-plus mx-1" aria-hidden="true"></i>Add New
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end position-relative mx-2">
                        <!-- Flash Messages -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
                <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="addNewModalLabel"
                    aria-hidden="true">
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
                                        <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-outline-primary">Save</button>
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
                                            <input type="email" class="form-control" name="email"
                                                value="{{ $registerRfid->email }}" readonly required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-outline-primary">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="filter-options">
                    <div class="filter-links">
                        <a href="#" class="active">All ({{ count($registerRfids) }})</a>
                    </div>
                </div>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Serial Number</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($registerRfids as $index => $registerRfid)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $registerRfid->id }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $registerRfid->username }}</strong>
                                    </td>
                                    <td>{{ $registerRfid->serial_number }}</td>
                                    <td>{{ $registerRfid->email }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                data-bs-target="#updateModal{{ $registerRfid->id }}">
                                                <i class="fa fa-pencil mr-1"></i>Update
                                            </a>

                                            <form action="{{ route('register-rfid.destroy', $registerRfid->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Are you sure you want to delete this RFID record?')">
                                                    <i class="fa fa-trash mr-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center mt-4 mb-4">
                            <li class="page-item {{ $registerRfids->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $registerRfids->previousPageUrl() }}"
                                    tabindex="-1">Previous</a>
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

            // Update the total count display
            const totalCountSpan = document.getElementById('total-count');
            if (totalCountSpan) {
                totalCountSpan.textContent = '{{ count($registerRfids) }}';
            }
        });

    </script>


@endsection