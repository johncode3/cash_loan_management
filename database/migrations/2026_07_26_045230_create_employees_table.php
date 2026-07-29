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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth');
            $table->string('position', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('phone', 15)->nullable()->unique();
            $table->string('email', 100)->unique()->nullable();
            $table->text('address')->nullable();
            $table->date('hiring_date')->nullable();
            $table->decimal('salary', 12, 2);
            $table->enum('status', ['Active', 'Inactive', 'Terminated', 'Resigned'])->default('Active');
            $table->string('profile_picture', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
