<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoanDetailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/process-data', function () {
    return view('process_data');
})->name('process.data');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Loan Form & Details Routes
    Route::get('/loan-form', [LoanDetailController::class, 'showForm'])->name('loan.form');
    Route::post('/loan-form', [LoanDetailController::class, 'store'])->name('loan.store');
    Route::get('/loan-details', [LoanDetailController::class, 'index'])->name('loan.details');
    Route::post('/process-data', [LoanDetailController::class, 'processData'])->name('process.data.submit');
    Route::get('/emi-details', [LoanDetailController::class, 'showEmiDetails'])->name('emi.details');


});

require __DIR__.'/auth.php';