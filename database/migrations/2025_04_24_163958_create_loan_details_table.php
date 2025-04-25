<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('loan_details', function (Blueprint $table) {
            $table->id();
            $table->integer('clientid'); // Client ID
            $table->integer('num_of_payment'); // Number of payments (EMIs)
            $table->date('first_payment_date'); // Start date
            $table->date('last_payment_date'); // End date
            $table->decimal('loan_amount', 15, 2); // Total loan amount (Sum of all EMIs)
            $table->timestamps(); // Created at, updated at
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('loan_details');
    }
};
