<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Payment List</title>
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
            <h1>Payment List</h1>
        </div>

        <div class="filter-options">
            <div class="filter-links">
                <a href="#" id="select-all-link">All (0)</a>
                <a href="#">Trashed (0)</a>
            </div>

            <div>
                <form method="POST" action="{{ route('membership-pendings.destroyAll') }}">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-light border mx-2" style="height: 35px;"
                            onclick="return confirm('Are you sure you want to delete all selected memberships?')">
                            <i class="fa fa-trash"></i> Move to Trash
                        </button>
                        <form class="d-flex" role="search">
                            <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                style="height: 35px;">
                            <button class="btn btn-primary ms-2" type="submit" style="height: 35px;">Search</button>
                        </form>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-container">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th class="text-center"><input type="checkbox" onclick="toggleSelectAll(this)" /></th>
                        <th class="text-center">ID</th>
                        <th class="text-center">Gcash Number</th>
                        <th class="text-center">Account Name</th>
                        <th class="text-center">Reference Number</th>
                        <th class="text-center">Proof of Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td class="text-center"><input type="checkbox" name="selected[]" value="{{ $payment->id }}" />
                            </td>
                            <td class="text-center">{{ $payment->id }}</td>
                            <td class="text-center">{{ $payment->gcash_number }}</td>
                            <td class="text-center">{{ $payment->account_name }}</td>
                            <td class="text-center">{{ $payment->reference_number }}</td>
                            <td class="text-center">
                                <a href="{{ asset($payment->proof_of_payment_url) }}" target="_blank">View Proof</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center mt-4">
                    <li class="page-item {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $payments->previousPageUrl() }}" tabindex="-1">Previous</a>
                    </li>

                    @foreach(range(1, $payments->lastPage()) as $page)
                        <li class="page-item {{ $page == $payments->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{$payments->url($page) }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ !$payments->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $payments->nextPageUrl() }}">Next</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

    <script>
        function toggleSelectAll(source) {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = source.checked;
            });
            updateSelectionCount();
        }

        function updateSelectionCount() {
            const checkboxes = document.querySelectorAll('input[name="selected[]"]:checked');
            const count = checkboxes.length;
            document.getElementById('select-all-link').innerText = `All (${count})`;
        }
    </script>

</body>
@endsection