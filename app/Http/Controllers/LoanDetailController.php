<?php

namespace App\Http\Controllers;

use App\Models\LoanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class LoanDetailController extends Controller
{
    // Show loan EMI form
    public function showForm()
    {
        return view('loan_form');
    }

    // Store loan details and calculate EMI
    public function store(Request $request)
    {
        $request->validate([
            'clientid' => 'required|integer',
            'num_of_payment' => 'required|integer',
            'first_payment_date' => 'required|date',
            'last_payment_date' => 'required|date',
            'loan_amount' => 'required|numeric',
        ]);

        // Save loan details
        $loanDetail = LoanDetail::create($request->all());

        // Calculate EMI
        $emi = $this->calculateEMI($loanDetail->loan_amount, $loanDetail->num_of_payment);

        // Pass EMI to the view or return response
        return view('loan_form', compact('emi'));
    }

    // Calculate EMI
    private function calculateEMI($loanAmount, $numPayments)
    {
        // Example EMI calculation logic (simplified)
        $rate = 0.10 / 12; // Assume 10% annual interest rate
        $emi = ($loanAmount * $rate * pow(1 + $rate, $numPayments)) / (pow(1 + $rate, $numPayments) - 1);
        return number_format($emi, 2);
    }

    public function index()
{
    $loanDetails = LoanDetail::all();
    return view('loan_details.index', compact('loanDetails'));
}

public function showProcessPage()
{
    // Fetch the EMI details data from the table
    $emiDetails = DB::table('emi_details')->get();

    return view('process_data', compact('emiDetails'));
}

public function processData(Request $request)
{
    $minDate = DB::table('loan_details')->min('first_payment_date');
    $maxDate = DB::table('loan_details')->max('last_payment_date');

    if (!$minDate || !$maxDate) {
        return redirect()->back()->with('status', 'No loan data found.');
    }

    $start = Carbon::parse($minDate)->startOfMonth();
    $end = Carbon::parse($maxDate)->startOfMonth();

    $columns = [];
    while ($start <= $end) {
        $col = $start->format('Y_M');
        $columns[] = $col;
        $start->addMonth();
    }

    // Drop and recreate emi_details
    DB::statement('DROP TABLE IF EXISTS emi_details');

    $columnSqls = array_map(fn($col) => "`$col` DECIMAL(10,2) DEFAULT 0", $columns);
    $sql = "CREATE TABLE emi_details (
        id INT AUTO_INCREMENT PRIMARY KEY,
        clientid INT NOT NULL,
        " . implode(', ', $columnSqls) . "
    )";

    DB::statement($sql);

    // Process the loan details and insert into emi_details table
    $loanDetails = DB::table('loan_details')->get();

    foreach ($loanDetails as $loan) {
        $loanAmount = $loan->loan_amount;

        // Correct column name here
        $numOfPayments = $loan->num_of_payment; // Use the correct column name 'num_of_payment'
        $emiAmount = $loanAmount / $numOfPayments;

        // Distribute EMI across months
        $emiValues = array_fill(0, count($columns), 0.0);
        $remainingAmount = $loanAmount;

        for ($i = 0; $i < $numOfPayments; $i++) {
            $emiValues[$i] = $emiAmount;
            $remainingAmount -= $emiAmount;
        }

        // Adjust the last month to ensure the total EMI equals the loan amount
        if ($remainingAmount != 0) {
            $emiValues[$numOfPayments - 1] += $remainingAmount;
        }

        // Insert data into emi_details table
        $data = ['clientid' => $loan->clientid];
        foreach ($columns as $index => $column) {
            $data[$column] = $emiValues[$index];
        }

        DB::table('emi_details')->insert($data);
    }

    return redirect()->route('process.data')->with([
        'status' => 'EMI Details table created with dynamic month columns and data processed!',
        'columns' => $columns,
    ]);
}


public function showEmiDetails()
{
    // Fetch all EMI details from the emi_details table
    $emiDetails = DB::table('emi_details')->get();

    // Fetch the list of month columns from the emi_details table
    $columns = Schema::getColumnListing('emi_details');
    $monthColumns = array_filter($columns, function($col) {
        return $col != 'id' && $col != 'clientid'; // Exclude 'id' and 'clientid' columns
    });

    return view('emi_details', compact('emiDetails', 'monthColumns'));
}


}
