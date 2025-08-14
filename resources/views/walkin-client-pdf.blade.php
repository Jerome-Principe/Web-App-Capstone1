<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk-in Clients Report</title>
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
    <h1>Walk-in Clients Report</h1>
    <p>Date: {{ $date ? \Carbon\Carbon::parse($date)->format('F d, Y') : 'All Dates' }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $totalAmount = 0; @endphp
            @foreach ($walkins as $index => $walkin)
                @php $totalAmount += $walkin->amount; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $walkin->lastname }}</td>
                    <td>{{ $walkin->firstname }}</td>
                    <td>{{ number_format($walkin->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">Total Amount</td>
                <td>{{ number_format($totalAmount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="3">Total Walk-ins</td>
                <td>{{ count($walkins) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>