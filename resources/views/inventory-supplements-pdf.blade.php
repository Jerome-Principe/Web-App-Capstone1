<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Supplements List Report</title>
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
    <h1>Inventory Supplements List Report</h1>
    <p>Date: {{ $date }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Supplement Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $Total = 0; @endphp
            @foreach ($supplements as $index => $supplement)
                        @php
                            $total = $supplement->quantity * $supplement->price;
                            $Total += $total;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $supplement->name }}</td>
                            <td>{{ $supplement->quantity }}</td>
                            <td>{{ number_format($supplement->price, 2) }}</td>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4">Total Amount</td>
                <td>{{ number_format($Total, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>