<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Membership List Report</title>
    <style>
        /* Base Styles for PDF */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            table-layout: fixed;
            page-break-inside: auto;
            /* Default behavior */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
            word-wrap: break-word;
            word-break: keep-all;
            /* <-- Add this */
        }

        td:last-child {
            white-space: nowrap;
            /* Prevent wrapping in Status */
        }


        th {
            background-color: #f4f4f4;
        }

        .total-row {
            font-weight: bold;
            background-color: #f4f4f4;
        }

        /* Styling for Total Rows */
        tfoot td {
            font-weight: bold;
            text-align: left;
        }

        /* Red for Declined status */
        .declined-status {
            color: red;
        }

        /* Adjustments for better PDF rendering */
        @page {
            size: A4;
            margin: 10mm;
            /* Margin for the entire page */
        }

        /* Page break before table if needed */
        .container {
            page-break-before: auto;
            /* This can be used if you only want a page break before specific sections */
        }

        /* Optional: Add a class for specific tables or elements you want to ensure are on the first page */
        .first-page-content {
            page-break-before: auto;
            /* Only for elements you want to ensure are not pushed to a new page */
        }

        /* Add a bottom margin to ensure total row is on the same page */
        .container-footer {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Membership List Report</h1>
        <p>Date: {{ $date ?? 'All Dates' }}</p>

        <table>
            <thead>
                <tr>
                    <th>#</th>
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
                        <td>{{ $membership->start_date ? \Carbon\Carbon::parse($membership->start_date)->format('Y-m-d') : 'N/A' }}
                        </td>
                        <td>{{ $membership->expiry_date ?? 'N/A' }}</td>
                        <td>{{ ucfirst(optional($membership->requestMembership)->membership_type ?? 'N/A') }}</td>
                        <td class="{{ $membership->status == 'Declined' ? 'declined-status' : '' }}">
                            {{ $membership->status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Container Footer to ensure Total Rows appear on the same page -->
    <div class="container-footer">
        <table>
            <tfoot>
                <tr class="total-row">
                    <td colspan="7">Total Memberships</td>
                    <td>{{ count($memberships) }}</td>
                </tr>
                <tr class="total-row">
                    <td colspan="7">Total Income</td>
                    <td>{{ number_format($totalIncome ?? 0, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>