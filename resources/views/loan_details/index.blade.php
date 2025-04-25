<!-- resources/views/loan_details/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Loan Details</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }
        th, td {
            padding: 8px 12px;
            border: 1px solid #ccc;
        }
        th {
            background-color: #eee;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>Loan Details</h1>

    @if($loanDetails->isEmpty())
        <p style="text-align:center;">No loan records found.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Client ID</th>
                    <th>Loan Amount</th>
                    <th>Payments</th>
                    <th>First Payment</th>
                    <th>Last Payment</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loanDetails as $loan)
                    <tr>
                        <td>{{ $loan->id }}</td>
                        <td>{{ $loan->clientid }}</td>
                        <td>{{ $loan->loan_amount }}</td>
                        <td>{{ $loan->num_of_payment }}</td>
                        <td>{{ $loan->first_payment_date }}</td>
                        <td>{{ $loan->last_payment_date }}</td>
                        <td>{{ $loan->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</body>
</html>
