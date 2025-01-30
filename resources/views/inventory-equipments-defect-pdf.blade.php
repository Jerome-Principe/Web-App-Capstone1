<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Equipments Defect List Report</title>
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
    <h1>Inventory Equipments Defect List Report</h1>
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
            @foreach($equipmentDefects as $equipmentDefect)
                <tr>
                    <td>{{ $equipmentDefect->id }}</td>
                    <td>{{ $equipmentDefect->equipment->item_name}}</td>
                    <td>{{ $equipmentDefect->quantity }}</td>
                    <td>{{ $equipmentDefect->defect }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3">Total Equipments Defect</td>
                <td>{{ number_format($equipmentDefects->sum('quantity')) }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>