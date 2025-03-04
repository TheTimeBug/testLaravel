<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bridge_loans', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('user_id'); // Borrower
            $table->unsignedBigInteger('bo_in_id'); // Borrower's bo account system id
            $table->decimal('loan_amount', 15, 2); // Loan amount
            $table->decimal('service_charge', 5, 2); // Service charge

            $table->date('start_date'); // Loan start date
            $table->time('start_time'); // Loan start time
            $table->date('end_date'); // Loan end date
                        
            $table->string('status', 2)->default('P'); // P=Pending, A=Approved, R=Rejected, C=Closed
            $table->string('remarks', 255)->nullable(); // Optional remarks
            
            $table->timestamp('created_at')->nullable(); // Timestamp for created_at
            $table->timestamp('updated_at')->nullable(); // Timestamp for updated_at

            // // Add the foreign key constraint for user_id
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // // Add the foreign key constraint for bo_in_id
            // $table->foreign('bo_in_id')->references('id')->on('bo_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bridge_loans'); // Drop the table if it exists
    }
};
