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
        Schema::table('payslips', function (Blueprint $table) {
        
        
         $table->decimal('normal_ot_pay')->nullable()->after('double_ot_hours');
         $table->decimal('double_ot_pay')->nullable()->after('normal_ot_pay');

        // $table->decimal('total_pf', 10, 2)->nullable()->after('before835Incentive');
        // $table->decimal('gross_salary', 10, 2)->nullable()->after('total_pf');
        
        // $table->decimal('informed_absent_days', 5, 2)->nullable()->after('gross_salary');
        // $table->decimal('uninformed_absent_days', 5, 2)->nullable()->after('informed_absent_days');
        // $table->decimal('late_attendance_days', 5, 2)->nullable()->after('uninformed_absent_days');
        // $table->decimal('half_day_leaves', 5, 2)->nullable()->after('late_attendance_days');
        // $table->decimal('other_deductions', 10, 2)->nullable()->after('half_day_leaves');
        // $table->decimal('gross_earnings', 10, 2)->nullable()->after('other_deductions');
        // $table->decimal('balance_salary', 10, 2)->nullable()->after('gross_earnings');
        // $table->decimal('employer_epf_contribution', 10, 2)->nullable()->after('balance_salary');
        // $table->decimal('etf', 10, 2)->nullable()->after('employer_epf_contribution');
        // $table->decimal('total_employer_contribution', 10, 2)->nullable()->after('etf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropColumn([
                'normal_ot_pay',
                'double_ot_pay'
            ]);
        });
    }
};
