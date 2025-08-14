<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Membership List Report</title>
    <style>
        /* Base Styles for PDF */
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
            table-layout: fixed;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            word-wrap: break-word;
            word-break: keep-all;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
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
            font-size: 14px;
            color: #333;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        /* Adjustments for better PDF rendering */
        @page {
            size: A4;
            margin: 10mm;
        }

        .container {
            page-break-before: auto;
        }

        .first-page-content {
            page-break-before: auto;
        }

        .container-footer {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>MEMBERSHIP LIST REPORT</h1>
        <p>FITDROID - Limitless Fitness Studio</p>
        <p>Generated on: {{ now()->format('M d, Y h:i A') }}</p>
    </div>

    <div class="summary">
        <h3>Report Summary</h3>
        <div class="summary-info">
            <span>Date Range:</span>
            <span>{{ $date ?? 'All Dates' }}</span>
        </div>
        <div class="summary-info">
            <span>Total Members:</span>
            <span>{{ $memberships->count() }}</span>
        </div>
        <div class="summary-info">
            <span>Approved Members:</span>
            <span>{{ $memberships->where('status', 'Approved')->count() }}</span>
        </div>
        <div class="summary-info">
            <span>Declined Members:</span>
            <span>{{ $memberships->where('status', 'Declined')->count() }}</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
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
                    <td>{{ $membership->start_date ? \Carbon\Carbon::parse($membership->start_date)->format('M d, Y') : 'N/A' }}
                    </td>
                    <td>{{ $membership->expiry_date ? \Carbon\Carbon::parse($membership->expiry_date)->format('M d, Y') : 'N/A' }}
                    </td>
                    <td>{{ ucfirst(optional($membership->requestMembership)->membership_type ?? 'N/A') }}</td>
                    <td
                        class="{{ $membership->status == 'Approved' ? 'status-approved' : ($membership->status == 'Declined' ? 'status-declined' : '') }}">
                        {{ $membership->status }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        @if($memberships->count() > 0)
            <tfoot>
                <tr class="total-row">
                    <td colspan="7" class="total-label"><strong>Total Members</strong></td>
                    <td class="total-amount"><strong>{{ $memberships->count() }}</strong></td>
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