<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Report</title>
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
            font-size: 10px;
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

        .status-approved {
            color: #28a745;
            font-weight: bold;
        }

        .status-declined {
            color: #dc3545;
            font-weight: bold;
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
            padding: 8px !important;
            background-color: #f5f5f5;
            font-size: 12px;
            color: #333;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .totals-breakdown {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .totals-breakdown h4 {
            margin: 0 0 10px 0;
            color: #333;
        }

        .breakdown-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 5px 0;
            border-bottom: 1px solid #ddd;
        }

        .breakdown-item:last-child {
            border-bottom: none;
            font-weight: bold;
            border-top: 2px solid #007bff;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>APPOINTMENTS REPORT</h1>
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
            <span>Total Appointments:</span>
            <span>{{ count($appointments) }}</span>
        </div>
        <div class="summary-info">
            <span>Approved Appointments:</span>
            <span>{{ $totalAppointments }}</span>
        </div>
        <div class="summary-info">
            <span>Total Amount (Approved Only):</span>
            <span>{{ number_format($totalAmount, 2) }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Instructor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Instructor Rate</th>
                <th>Gym Rate</th>
                <th>Total Amount</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $index => $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->pendingMembership->name ?? 'N/A' }}</td>
                    <td>{{ $appointment->instructor->first_name ?? '' }} {{ $appointment->instructor->last_name ?? '' }}
                    </td>
                    <td>{{ $appointment->selected_date }}</td>
                    <td>{{ $appointment->selected_time }}</td>
                    <td class="amount">{{ number_format($appointment->instructor_rate ?? 0, 2) }}</td>
                    <td class="amount">{{ number_format($appointment->gym_rate ?? 0, 2) }}</td>
                    <td class="amount">{{ number_format($appointment->total_amount ?? 0, 2) }}</td>
                    <td class="{{ $appointment->status === 'Approved' ? 'status-approved' : 'status-declined' }}">
                        {{ $appointment->status }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">No appointments found for the selected date range.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(count($appointments) > 0)
        <div class="totals-breakdown">
            <h4>Totals Breakdown (Approved Appointments Only)</h4>
            <div class="breakdown-item">
                <span>Total Instructor Rate:</span>
                <span>{{ number_format($totalInstructorRate, 2) }}</span>
            </div>
            <div class="breakdown-item">
                <span>Total Gym Rate:</span>
                <span>{{ number_format($totalGymRate, 2) }}</span>
            </div>
            <div class="breakdown-item">
                <span>Grand Total Amount:</span>
                <span>{{ number_format($totalAmount, 2) }}</span>
            </div>
        </div>
    @endif

    <div class="footer">
        <p>This report was generated automatically by the FITDROID system.</p>
        <p>For any questions or concerns, please contact the administrator.</p>
        <p><strong>Note:</strong> Totals include only approved appointments. Declined appointments are excluded from
            calculations.</p>
    </div>
</body>

</html>