<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

    <title>Push Notification Form</title>

    <style>
        .container {
            max-width: 800px;
            margin: 30px auto;
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
    </style>
</head>

@extends('layouts.master')

@section('content')

<body>
    <div class="container">
        <div>
            <h1 class="mb-2">Create Announcements</h1>
            <p class="text-muted" style="font-style: italic;">
                Field marked with an asterisk <span class="text-danger">(*)</span> are required.
            </p>
        </div>
        <form>
            <div class="mb-3">
                <label for="notificationText" class="form-label mt-5">Text in Push Notification <span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" id="notificationText"
                    placeholder="Enter Text in Push Notification" required>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control custom-textarea" rows="5"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Attach PDF File</label>
                    <div id="pdfDropzone" class="pdf-dropzone" ondrop="handleFileDrop(event)"
                        ondragover="handleDragOver(event)" onclick="selectPDFFile()">
                        Drag and Drop File Here<br>(or click to select files)
                    </div>
                    <input type="file" id="pdfFile" accept="application/pdf" class="form-control d-none"
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

    <script>
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
    </script>
</body>

</html>
@endsection