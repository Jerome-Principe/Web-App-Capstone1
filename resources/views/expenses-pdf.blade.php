<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenses Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
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
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
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
        }

        .summary-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .summary-info span {
            font-weight: bold;
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
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .amount {
            text-align: right;
            font-weight: bold;
        }

        .total-row {
            background-color: #e9ecef !important;
            font-weight: bold;
        }

        .total-row td {
            border: none !important;
        }

        .total-label {
            text-align: right !important;
        }

        .total-amount {
            text-align: right !important;
            border: 2px solid #333 !important;
            padding: 10px !important;
            border-radius: 5px;
            background-color: #fff;
            font-size: 16px;
            color: #333;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        <h1>EXPENSES REPORT</h1>
        <p>FITDROID - Limitless Fitness Studio</p>
        <p>Generated on: {{ now()->format('M d, Y h:i A') }}</p>
    </div>

    <div class="summary">
        <h3>Report Summary</h3>
        <div class="summary-info">
            <span>Date Range:</span>
            <span>{{ $date ? \Carbon\Carbon::parse($date)->format('F d, Y') : 'All Dates' }}</span>
        </div>
        <div class="summary-info">
            <span>Total Expenses:</span>
            <span>{{ $expenses->count() }}</span>
        </div>
        <div class="summary-info">
            <span>Total Amount:</span>
            <span>{{ number_format($totalAmount, 2) }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Expense Description</th>
                <th>Amount</th>
                <th>Payment Method</th>
            </tr>
        </thead>
        <tbody>
            @forelse($expenses as $index => $expense)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('M d, Y') }}</td>
                    <td>{{ $expense->expense_description }}</td>
                    <td class="amount">{{ number_format($expense->amount, 2) }}</td>
                    <td>{{ $expense->payment_method }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No expenses found for the selected date range.</td>
                </tr>
            @endforelse

            @if($expenses->count() > 0)
                <tr class="total-row">
                    <td colspan="3" class="total-label"><strong>Total:</strong></td>
                    <td class="total-amount"><strong>{{ number_format($totalAmount, 2) }}</strong></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <p>This report was generated automatically by the FITDROID system.</p>
        <p>For any questions or concerns, please contact the administrator.</p>
    </div>
</body>

</html>