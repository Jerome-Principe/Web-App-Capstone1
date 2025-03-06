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
            padding: 10px;
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
                <th>Email</th>
                <th>Start Date</th>
                <th>Expiry Date</th>
                <th>Membership Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($memberships as $index => $membership)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $membership->first_name }}</td>
                    <td>{{ $membership->last_name }}</td>
                    <td>{{ $membership->email }}</td>
                    <td>{{ $membership->start_date ? \Carbon\Carbon::parse($membership->start_date)->format('Y-m-d') : 'N/A' }}
                    </td>
                    <td>{{ $membership->expiry_date ?? 'N/A' }}</td>
                    <td>{{ ucfirst(optional($membership->requestMembership)->membership_type ?? 'N/A') }}</td>
                    <td>{{ $membership->status }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="7">Total Memberships</td>
                <td>{{ count($memberships) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="7">Total Income</td>
                <td>{{ number_format($totalIncome ?? 0, 2) }}</td>
            </tr>
        </tfoot>
    </table>

</body>

</html>