<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Machines Defect List Report</title>
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
    <h1>Inventory Machines Defect List Report</h1>
    <p>Date: {{ $date ?? 'All Dates' }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Defect</th>
            </tr>
        </thead>
        <tbody>
            @foreach($machineDefects as $machineDefect)
                <tr>
                    <td>{{ $machineDefect->id }}</td>
                    <td>{{ $machineDefect->machine->item_name}}</td>
                    <td>{{ $machineDefect->quantity }}</td>
                    <td>{{ $machineDefect->defect }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">Total Machines Defect</td>
                <td>{{ number_format($machineDefects->sum('quantity')) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>