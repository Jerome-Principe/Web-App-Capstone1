<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

    <title>Push Notification Form</title>

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

        /* Minimalist Form Styles */
        .form-section h2 {
            font-size: 20px;
            font-weight: 500;
            color: #333;
            margin-bottom: 24px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e1e5e9;
        }

        .form-label {
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 14px;
            transition: border-color 0.2s ease;
            background: white;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .custom-textarea {
            height: 120px;
            resize: vertical;
        }

        /* Minimalist PDF Dropzone */
        .pdf-dropzone {
            border: 2px dashed #ddd;
            border-radius: 4px;
            padding: 32px 16px;
            text-align: center;
            color: #666;
            background: #fafafa;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .pdf-dropzone:hover {
            border-color: #007bff;
            background: #f8f9fa;
        }

        .pdf-dropzone.dragover {
            border-color: #007bff;
            background: #f0f8ff;
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

        .btn-outline-dark {
            background: transparent;
            color: #333;
            border-color: #333;
        }

        .btn-outline-dark:hover {
            background: #333;
            color: white;
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
            text-align: left;
            border-bottom: 1px solid #e1e5e9;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid #f1f3f4;
            vertical-align: middle;
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
        .custom-alert-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 16px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
            font-size: 14px;
            margin-left: 16px;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            border-radius: 4px;
            padding: 12px 16px;
            font-size: 14px;
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
        }

        /* Loading State */
        .loading {
            opacity: 0.7;
            pointer-events: none;
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
                <h1>Announcements</h1>
                <p>Manage your fitness studio announcements and notifications</p>
            </div>

            <!-- Create Announcements Section -->
            <div class="content-card">
                <div class="form-section">
                    <h2>Create Announcement</h2>

                    <div class="d-flex align-items-center mb-4">
                        @if(session('success'))
                            <div class="custom-alert-message">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>

                    <div class="alert alert-info" role="alert">
                        Fields marked with an asterisk <span class="text-danger">(*)</span> are required.
                    </div>

                    <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="notificationText" class="form-label">
                                    Text in Push Notification <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="notificationText" name="notification_text"
                                    placeholder="Enter your announcement text..." required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control custom-textarea"
                                    placeholder="Enter detailed description..."></textarea>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Attach PDF File</label>
                                <div id="pdfDropzone" class="pdf-dropzone" ondrop="handleFileDrop(event)"
                                    ondragover="handleDragOver(event)" onclick="selectPDFFile()">
                                    <div class="dropzone-content">
                                        <i class="fa fa-cloud-upload fa-2x mb-3"></i>
                                        <p class="mb-2">Drag and drop PDF here</p>
                                        <p class="text-muted">or click to select files</p>
                                    </div>
                                </div>
                                <input type="file" id="pdfFile" name="pdf_file" accept="application/pdf"
                                    class="form-control d-none" onchange="displayFileName(event)">
                                <button type="button" class="btn btn-secondary mt-3 w-100" onclick="selectPDFFile()">
                                    Select PDF File
                                </button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <button type="button" class="btn btn-outline-dark">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- All Announcements Section -->
            <div class="content-card">
                <div class="table-section">
                    <h2>All Announcements</h2>

                    <div class="filter-options">
                        <div class="filter-links">
                            <a href="#" id="select-all-link" class="active">
                                All ({{ $announcements->count() }})
                            </a>
                            <a href="{{ route('announcements.trashed') }}">
                                Archived ({{ App\Models\Announcement::onlyTrashed()->count() }})
                            </a>
                        </div>

                        <div>
                            <form action="{{ route('announcements.moveToTrash') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="selected" id="selectedIds">
                                <button type="submit" class="btn btn-light border btn-sm" id="moveToArchiveBtn" disabled>
                                    <i class="fa fa-trash me-1"></i>Move to Archive
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Table section -->
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" onclick="toggleSelectAll(this)" />
                                    </th>
                                    <th style="width: 60px;">ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th style="width: 100px;">File</th>
                                    <th style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($announcements as $announcement)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="selected[]" value="{{ $announcement->id }}"
                                                onchange="updateSelectionCount()" />
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $announcement->id }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $announcement->notification_text }}</strong>
                                        </td>
                                        <td>
                                            {{ Str::limit($announcement->description, 50) }}
                                        </td>
                                        <td>
                                            @if($announcement->pdf_file)
                                                <a href="{{ url('storage/app/public/' . $announcement->pdf_file) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-dark">
                                                    View PDF
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="#" class="btn btn-sm btn-primary edit-btn"
                                                    data-id="{{ $announcement->id }}"
                                                    data-notification="{{ $announcement->notification_text }}"
                                                    data-description="{{ $announcement->description }}"
                                                    data-pdf="{{ url('storage/app/public/' . $announcement->pdf_file) }}"
                                                    data-bs-toggle="modal" data-bs-target="#editAnnouncementModal">
                                                    update
                                                </a>
                                                <form action="{{ route('announcements.destroy', $announcement->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this announcement?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="empty-state">
                                                <i class="fa fa-inbox"></i>
                                                <h5>No announcements found</h5>
                                                <p>Create your first announcement to get started</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if($announcements->hasPages())
                            <nav aria-label="Page navigation">
                                <ul class="pagination">
                                    <li class="page-item {{ $announcements->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $announcements->previousPageUrl() }}">
                                            Previous
                                        </a>
                                    </li>

                                    @foreach(range(1, $announcements->lastPage()) as $page)
                                        <li class="page-item {{ $page == $announcements->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $announcements->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <li class="page-item {{ !$announcements->hasMorePages() ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ $announcements->nextPageUrl() }}">
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

        <!-- Edit Announcement Modal -->
        <div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAnnouncementModalLabel">
                            Edit Announcement
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editAnnouncementForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="editAnnouncementId" name="id">

                            <div class="mb-3">
                                <label for="editNotificationText" class="form-label">
                                    Text in Push Notification <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="editNotificationText" name="notification_text"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="editDescription" class="form-label">Description</label>
                                <textarea id="editDescription" name="description" class="form-control custom-textarea"
                                    rows="5"></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Attach New PDF File</label>
                                <input type="file" id="editPdfFile" name="pdf_file" accept="application/pdf"
                                    class="form-control">
                                <div id="currentPdfFile" class="mt-2"></div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Update Announcement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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
                const totalCount = document.querySelectorAll('input[name="selected[]"]').length;

                document.getElementById('select-all-link').textContent = `All (${count}/${totalCount})`;

                const selectedIds = Array.from(selectedCheckboxes).map(input => input.value);
                document.getElementById('selectedIds').value = selectedIds.join(',');

                // Enable/disable move to archive button
                const moveToArchiveBtn = document.getElementById('moveToArchiveBtn');
                moveToArchiveBtn.disabled = count === 0;

                // Update select all checkbox
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = count === totalCount && totalCount > 0;
                selectAllCheckbox.indeterminate = count > 0 && count < totalCount;
            }

            // Add functionality for the "All" link click
            document.getElementById('select-all-link').addEventListener('click', function (e) {
                e.preventDefault();
                const selectAllCheckbox = document.querySelector('th input[type="checkbox"]');
                selectAllCheckbox.checked = !selectAllCheckbox.checked;
                toggleSelectAll(selectAllCheckbox);
            });

            // PDF Dropzone functionality
            function handleDragOver(event) {
                event.preventDefault();
                document.getElementById('pdfDropzone').classList.add('dragover');
            }

            function handleFileDrop(event) {
                event.preventDefault();
                document.getElementById('pdfDropzone').classList.remove('dragover');
                const file = event.dataTransfer.files[0];
                if (file && file.type === 'application/pdf') {
                    document.getElementById('pdfFile').files = event.dataTransfer.files;
                    displayFileName();
                } else {
                    alert('Please select a PDF file.');
                }
            }

            function selectPDFFile() {
                document.getElementById('pdfFile').click();
            }

            function displayFileName(event) {
                const file = document.getElementById('pdfFile').files[0];
                const dropzone = document.getElementById('pdfDropzone');
                if (file) {
                    dropzone.innerHTML = `
                                        <div class="dropzone-content">
                                            <i class="fa fa-file-pdf-o fa-2x mb-3 text-success"></i>
                                            <p class="mb-2"><strong>${file.name}</strong></p>
                                            <p class="text-muted">File selected</p>
                                        </div>
                                    `;
                }
            }

            // Edit modal functionality
            document.addEventListener("DOMContentLoaded", function () {
                const editButtons = document.querySelectorAll(".edit-btn");

                editButtons.forEach(button => {
                    button.addEventListener("click", function () {
                        const id = this.getAttribute("data-id");
                        const notificationText = this.getAttribute("data-notification");
                        const description = this.getAttribute("data-description");
                        const pdfFile = this.getAttribute("data-pdf");

                        // Set values in the modal
                        document.getElementById("editAnnouncementId").value = id;
                        document.getElementById("editNotificationText").value = notificationText;
                        document.getElementById("editDescription").value = description;

                        if (pdfFile && pdfFile !== 'http://127.0.0.1:8000/storage/app/public/') {
                            document.getElementById("currentPdfFile").innerHTML =
                                `<a href="${pdfFile}" target="_blank" class="btn btn-sm btn-outline-dark">
                                                    View Current PDF
                                                </a>`;
                        } else {
                            document.getElementById("currentPdfFile").innerHTML =
                                '<span class="text-muted">No PDF file attached</span>';
                        }

                        // Update the form action dynamically
                        document.getElementById("editAnnouncementForm").setAttribute("action", `/announcements/${id}`);
                    });
                });

                // Auto-hide success message
                setTimeout(function () {
                    const alert = document.querySelector('.custom-alert-message');
                    if (alert) {
                        alert.classList.add('fade-out');
                    }
                }, 5000);
            });

            // Add loading state to buttons
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function () {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;
                    }
                });
            });
        </script>
    </body>

    </html>
@endsection