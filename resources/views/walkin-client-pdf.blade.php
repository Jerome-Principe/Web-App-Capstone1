<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Walk-in Client Report</title>
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
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Walk-in Clients Report</h1>
    <p>Date: {{ $date }}</p>
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
            @foreach ($walkins as $index => $walkin)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $walkin->lastname }}</td>
                    <td>{{ $walkin->firstname }}</td>
                    <td>{{ $walkin->amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p>Total Names: {{ $totalNames }}</p>
    <p>Total Amount: {{ $totalAmount }}</p>
</body>

</html>