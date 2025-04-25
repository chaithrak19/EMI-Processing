<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan EMI Calculator</title>
</head>
<body>
    <h1>Loan EMI Calculator</h1>

    <form method="POST" action="{{ route('loan.store') }}">
        @csrf
        <label for="clientid">Client ID:</label>
        <input type="number" name="clientid" required><br><br>

        <label for="num_of_payment">Number of Payments:</label>
        <input type="number" name="num_of_payment" required><br><br>

        <label for="first_payment_date">First Payment Date:</label>
        <input type="date" name="first_payment_date" required><br><br>

        <label for="last_payment_date">Last Payment Date:</label>
        <input type="date" name="last_payment_date" required><br><br>

        <label for="loan_amount">Loan Amount:</label>
        <input type="number" name="loan_amount" required><br><br>

        <button type="submit">Calculate EMI</button>
    </form>

    @if(isset($emi))
        <h3>Calculated EMI: ₹{{ $emi }}</h3>
    @endif
</body>
</html>
