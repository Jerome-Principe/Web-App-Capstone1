<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Machines List Report</title>
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
    <h1>Inventory Machines List Report</h1>
    <p>Date: {{ $date ?? 'All Dates' }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($machines as $machine)
                <tr>
                    <td>{{ $machine->id }}</td>
                    <td>{{ $machine->item_name }}</td>
                    <td>{{ $machine->quantity }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2">Total Machines</td>
                <td>{{ number_format($machines->sum('quantity')) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>