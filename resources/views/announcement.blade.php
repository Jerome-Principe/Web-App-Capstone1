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
        /* create-announcement */
        .container {
            max-width: 800px;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .pdf-dropzone {
            border: 2px dashed #ccc;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            color: #888;
            background-color: #D3D3D3;
        }

        .pdf-dropzone.dragover {
            border-color: #007bff;
            background-color: #e9f5ff;
        }

        .custom-textarea {
            height: 200px;
        }

        /* all-announcement */
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

        .add-new {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
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

        .move-trash {
            background-color: #ADD8E6;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .move-trash i {
            margin-right: 5px;
        }

        .search-bar {
            display: flex;
            align-items: center;
        }

        .input-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-container input[type="search"] {
            padding-left: 30px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .input-container i {
            position: absolute;
            left: 10px;
            color: #aaa;
            pointer-events: none;
            transition: opacity 0.2s ease-in-out;
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

        th {
            background-color: #f0f0f0;
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
        <!-- Create Announcements -->
        <div class="container">

            <div class="d-flex align-items-center">
                <h1 class="mb-2 me-3">Create Announcements</h1>

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

            <div>
                <p class="text-muted" style="font-style: italic;">
                    Field marked with an asterisk <span class="text-danger">(*)</span> are required.
                </p>
            </div>

            <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="notificationText" class="form-label mt-5">Text in Push Notification <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="notificationText" name="notification_text"
                        placeholder="Enter Text in Push Notification" required>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-6">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control custom-textarea"
                            rows="5"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Attach PDF File</label>
                        <div id="pdfDropzone" class="pdf-dropzone" ondrop="handleFileDrop(event)"
                            ondragover="handleDragOver(event)" onclick="selectPDFFile()">
                            Drag and Drop File Here<br>(or click to select files)
                        </div>

                        <input type="file" id="pdfFile" name="pdf_file" accept="application/pdf" class="form-control d-none"
                            onchange="displayFileName(event)">
                        <button type="button" class="btn btn-secondary mt-2" onclick="selectPDFFile()">Select PDF
                            File</button>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary">Preview & Save as Draft</button>
                    <div>
                        <button type="button" class="btn btn-outline-dark me-2 px-2">Cancel</button>
                        <button type="submit" class="btn btn-primary px-3">Save</button>
                    </div>
                </div>

            </form>

        </div>

        <!-- All Announcements -->
        <div class="container">
            <div class="header-section">
                <h1>All Announcements</h1>
            </div>

            <div class="filter-options">
                <div class="filter-links">
                    <!-- Link to view all -->
                    <a href="#" id="select-all-link">All (0)</a>

                    <!-- Link to view all trashed announcements -->
                    <a href="{{ route('announcements.trashed') }}">Trashed
                        ({{ App\Models\Announcement::onlyTrashed()->count() }})
                    </a>

                </div>

                <div>
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <form action="{{ route('announcements.moveToTrash') }}" method="POST">
                            @csrf
                            <input type="hidden" name="selected" id="selectedIds">
                            <button type="submit" class="btn btn-light border mx-2">
                                <i class="fa fa-trash"></i> Move to Trash
                            </button>
                        </form>

                    </div>
                </div>

            </div>

            <!-- Table section -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">FILE</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($announcements as $announcement)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $announcement->id }}"
                                        onchange="updateSelectionCount()" />
                                </td>
                                <td class="text-center">{{ $announcement->id }}</td>
                                <td class="text-center">{{ $announcement->notification_text }}</td>
                                <td class="text-center">{{ $announcement->description }}</td>
                                <td class="text-center">
                                    <a href="{{ Storage::url($announcement->pdf_file) }}" target="_blank">View PDF</a>
                                </td class="text-center">
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-sm btn-primary edit-btn mx-1"
                                            data-id="{{ $announcement->id }}"
                                            data-notification="{{ $announcement->notification_text }}"
                                            data-description="{{ $announcement->description }}"
                                            data-pdf="{{ asset('storage/' . $announcement->pdf_file) }}" data-bs-toggle="modal"
                                            data-bs-target="#editAnnouncementModal">
                                            <i class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update
                                        </a>
                                        <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mx-1"
                                                onclick="return confirm('Are you sure you want to delete this Announcements?')">
                                                <i class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center mt-4">
                        <li class="page-item {{ $announcements->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $announcements->previousPageUrl() }}" tabindex="-1">Previous</a>
                        </li>

                        @foreach(range(1, $announcements->lastPage()) as $page)
                            <li class="page-item {{ $page == $announcements->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{$announcements->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <li class="page-item {{ !$announcements->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $announcements->nextPageUrl() }}">Next</a>
                        </li>
                    </ul>
                </nav>

            </div>
        </div>

        <!-- Edit Announcement Modal -->
        <div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAnnouncementModalLabel">Edit Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editAnnouncementForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="editAnnouncementId" name="id">

                            <div class="mb-3">
                                <label for="editNotificationText" class="form-label">Text in Push Notification <span
                                        class="text-danger">*</span></label>
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
                                <p id="currentPdfFile" class="mt-2"></p>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
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
                }
            }

            function selectPDFFile() {
                document.getElementById('pdfFile').click();
            }

            function displayFileName(event) {
                const file = document.getElementById('pdfFile').files[0];
                if (file) {
                    document.getElementById('pdfDropzone').innerText = file.name;
                }
            }

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
                        document.getElementById("currentPdfFile").innerHTML = `<a href="${pdfFile}" target="_blank">View Current PDF</a>`;

                        // Update the form action dynamically
                        document.getElementById("editAnnouncementForm").setAttribute("action", `/announcements/${id}`);
                    });
                });
            });

        </script>
    </body>

    </html>
@endsection