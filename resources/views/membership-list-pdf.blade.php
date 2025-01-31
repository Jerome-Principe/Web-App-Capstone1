<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership List Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f4f4f4;
        }

        .total-row {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Membership List Report</h1>
    <p>Date: {{ $date ?? 'All Dates' }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date / Time</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($memberships as $membership)
                <tr>
                    <td>{{ $membership->id }}</td>
                    <td>{{ $membership->first_name }}</td>
                    <td>{{ $membership->last_name }}</td>
                    <td>{{ $membership->created_at }}</td>
                    <td>{{ $membership->email }}</td>
                </tr>
            @endforeach
        </tbody>
        <tr class="total-row">
            <td colspan="4">Total Memberships</td>
            <td>{{ count($memberships) }}</td>
        </tr>
    </table>
</body>

</html>