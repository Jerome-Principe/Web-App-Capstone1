<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Add Drinks List</title>
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
            <h1>Drinks List</h1>
            <div>
                <div class="d-flex justify-content-end position-relative">
                    <a href="/drinks/create" class="btn btn-primary px-2"><i class="fa fa-plus mx-1"
                            aria-hidden="true"></i>Add New</a>
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
                        onclick="return confirm('Are you sure you want to delete all selected drinks?')"><i
                            class="fa fa-trash"></i> Move to Trash</button>
                    <form class="d-flex" role="search">
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
                        <th class="text-center">Drink Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Date</th>
                        <th class="text-center">Time</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($drinks as $index => $drink)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $drink->id }}"
                                    onchange="updateSelectionCount()" /></td>
                            <td class="text-center">
                                {{ ($drinks->currentPage() - 1) * $drinks->perPage() + $index + 1 }}
                            </td>
                            <td class="text-center">{{ $drink->item_name }}</td>
                            <td class="text-center">{{ $drink->quantity }}</td>
                            <td class="text-center">{{ $drink->price }}</td>
                            <td class="text-center">{{ $drink->total }}</td>
                            <td class="text-center">{{ $drink->date }}</td>
                            <td class="text-center">{{ $drink->time }}</td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('drinks.edit', $drink->id) }}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-pencil-square-o mx-1" aria-hidden="true"></i>Update</a>
                                <form action="{{ route('drinks.destroy', $drink->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mx-1"
                                        onclick="return confirm('Are you sure you want to delete this drink?')"><i
                                            class="fa fa-trash-o mx-1" aria-hidden="true"></i>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                <h5>Total Price = {{ $totalPrice }}</h5>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mt-4">
                    <li class="page-item {{ $drinks->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $drinks->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>

                    @foreach(range(1, $drinks->lastPage()) as $page)
                        <li class="page-item {{ $page == $drinks->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $drinks->url($page) }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ !$drinks->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $drinks->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <script>
        // Select all checkboxes
        function toggleSelectAll(source) {
            checkboxes = document.getElementsByName('selected[]');
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
            updateSelectionCount();
        }

        // Update the selection count
        function updateSelectionCount() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const count = checkboxes.length;
            document.getElementById('select-all-link').innerText = `All (${count})`;
        }
    </script>

</body>

</html>
@endsection