<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Machines List Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #333;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 10px;
        }

        .summary {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .summary h3 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 12px;
        }

        .summary-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 10px;
        }

        .summary-info span {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 9px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            word-wrap: break-word;
            word-break: keep-all;
            vertical-align: middle;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
            line-height: 1.2;
        }

        td {
            font-size: 9px;
            line-height: 1.2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .total-row {
            background-color: #f5f5f5 !important;
            font-weight: bold;
            border: 2px solid #007bff !important;
            border-radius: 5px;
        }

        .total-label {
            text-align: center !important;
            border: 2px solid #007bff !important;
        }

        .total-amount {
            text-align: center !important;
            border: 2px solid #007bff !important;
            padding: 6px !important;
            background-color: #f5f5f5;
            font-size: 11px;
            color: #333;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>INVENTORY MACHINES LIST REPORT</h1>
        <p>FITDROID - Limitless Fitness Studio</p>
        <p>Generated on: {{ now()->format('M d, Y h:i A') }}</p>
    </div>

    <div class="summary">
        <h3>Report Summary</h3>
        <div class="summary-info">
            <span>Date Range:</span>
            <span>{{ $date && $date !== 'All Dates' ? \Carbon\Carbon::parse($date)->format('F d, Y') : 'All Dates' }}</span>
        </div>
        <div class="summary-info">
            <span>Total Machines:</span>
            <span>{{ $machines->count() }}</span>
        </div>
        <div class="summary-info">
            <span>Total Quantity:</span>
            <span>{{ $machines->sum('quantity') }}</span>
        </div>
    </div>

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
        @if($machines->count() > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="2" class="total-label"><strong>Total Machines</strong></td>
                    <td class="total-amount"><strong>{{ number_format($machines->sum('quantity')) }}</strong></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>This report was generated automatically by the FITDROID system.</p>
        <p>For any questions or concerns, please contact the administrator.</p>
    </div>
</body>

</html>