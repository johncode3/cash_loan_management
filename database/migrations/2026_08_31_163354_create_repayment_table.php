<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations (Task B.8).
     */
    public function up(): void
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_id')->constrained('loans')->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('loan_schedules')->nullOnDelete();
            $table->decimal('amount_paid', 12, 2);
            $table->date('payment_date');
            $table->string('payment_method')->default('Cash');
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayments');
    }
};