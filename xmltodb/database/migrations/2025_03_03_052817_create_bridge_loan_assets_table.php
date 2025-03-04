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
        Schema::create('bridge_loan_assets', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('bridge_loan_id'); // Foreign key to bridge_loans table
            $table->unsignedBigInteger('treade_id'); // Foreign key to trades table
            $table->decimal('asset_value', 15, 2); // Asset value
            $table->decimal('loan_amount', 15, 2); // Loan amount
            $table->decimal('service_charge', 5, 2); // Service charge
            $table->date('end_date'); // Loan end date
            $table->string('status', 2)->default('P'); // P=Pending, A=Approved, R=Rejected, C=Closed
            $table->string('remarks', 255)->nullable(); // Optional remarks
            $table->timestamp('created_at')->nullable(); // Timestamp for created_at
            $table->timestamp('updated_at')->nullable(); // Timestamp for updated_at

            // Add the foreign key constraint
            $table->foreign('bridge_loan_id')->references('id')->on('bridge_loans')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bridge_loan_assets'); // Drop the table if it exists
    }
};
