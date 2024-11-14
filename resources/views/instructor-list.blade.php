<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
    </style>
</head>

@extends('layouts.master')

@section('content')

<body>
    <div class="container">
        <div class="header-section">
            <h1>Instructor List</h1>
        </div>

        <!-- Form to Add New Instructor -->
        <div class="mb-4">
            <h3>Add New Instructor</h3>
            <form action="{{ route('instructors.store') }}" method="POST">
                @csrf
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
                <button type="submit" class="btn btn-primary">Add Instructor</button>
            </form>
            @if(session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif
        </div>

        <!-- Instructor List Table -->
        <div class="table-container">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
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
                            <td>{{ $instructor->id }}</td>
                            <td>{{ $instructor->first_name }}</td>
                            <td>{{ $instructor->last_name }}</td>
                            <td>{{ $instructor->expertise ?? 'N/A' }}</td>
                            <td>${{ number_format($instructor->rates, 2) }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
@endsection