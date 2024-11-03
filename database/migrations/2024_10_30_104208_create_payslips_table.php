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
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
          
            $table->string('emp_no'); // Employee number
            $table->string('emp_name'); // Employee name
            $table->decimal('base_salary', 10, 2); // Base salary
            $table->decimal('attendance_incentive', 8, 2)->nullable(); // Attendance incentive
            $table->decimal('other_incentive', 8, 2)->nullable(); // Other incentive
            $table->decimal('normal_ot_hours', 5, 2)->nullable(); // Normal OT hours
            $table->decimal('double_ot_hours', 5, 2)->nullable(); // Double OT hours
            $table->decimal('epf', 8, 2)->nullable(); // EPF deduction
            $table->decimal('salary_advance', 8, 2)->nullable(); // Salary advance deduction
            $table->decimal('total_deductions', 10, 2)->nullable(); // Total deductions
            $table->decimal('net_salary', 10, 2)->nullable(); // Net salary
            $table->string('month'); // Month for the payslip
            $table->timestamps(); // Adds created_at and updated_at columns (only once)
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
