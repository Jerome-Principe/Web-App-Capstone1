<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap Css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="styles.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>All Announcements</title>

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
    <div class="container">
        <div class="header-section">
            <h1>All Announcements</h1>
            <button class="add-new">Add New</button>
        </div>

        <div class="filter-options">
            <div class="filter-links">
                <a href="#">Sent (0)</a>
                <a href="#">Scheduled (0)</a>
                <a href="#">Draft (0)</a>
                <a href="#">Trashed (0)</a>
                <a href="#">All (0)</a>
            </div>

            <!-- Search bar section -->
            <div class="search-bar">
                <button class="move-trash mx-2">
                    <i class="fas fa-trash"></i> Move to Trash
                </button>

                <form class="d-flex" role="search">
                    <div class="input-container">
                        <i class="fas fa-search"></i>
                        <input class="form-control" type="search" aria-label="Search" id="search-input">
                    </div>
                    <button class="btn btn-outline-primary" type="submit">Search</button>
                </form>
            </div>
        </div>

        <!-- Table section -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox"></th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Author</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td></td>
                        <td></td>
                        <td><br><span class="date-info"></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td></td>
                        <td></td>
                        <td><br><span class="date-info"></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td></td>
                        <td></td>
                        <td><br><span class="date-info"></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td></td>
                        <td></td>
                        <td><br><span class="date-info"></span></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><input type="checkbox"></td>
                        <td></td>
                        <td></td>
                        <td><br><span class="date-info"></span></td>
                        <td></td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // JavaScript to hide/show search icon based on input
        const searchInput = document.getElementById('search-input');
        const searchIcon = document.querySelector('.input-container i');

        searchInput.addEventListener('input', function () {
            if (searchInput.value.length > 0) {
                searchIcon.style.opacity = '0';
            } else {
                searchIcon.style.opacity = '1';
            }
        });
    </script>

</body>

</html>

@endsection