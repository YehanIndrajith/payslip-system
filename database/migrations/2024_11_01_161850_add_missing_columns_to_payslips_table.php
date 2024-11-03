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

            $table->decimal('before835Incentive')->nullable()->after('other_incentive');
            $table->decimal('total_pf', 10, 2)->nullable()->after('before835Incentive'); // Total PF
            $table->decimal('gross_salary', 10, 2)->nullable()->after('total_pf'); // Gross Salary
            
            $table->decimal('informed_absent_days')->nullable()->after('gross_salary'); // Informed absent days -- values have to included in decimal
            $table->decimal('uninformed_absent_days')->nullable()->after('informed_absent_days'); // Uninformed absent days  -- values have to included in decimal
            $table->decimal('late_attendance_days')->nullable()->after('uninformed_absent_days'); // Late attendance days  -- values have to included in decimal
            $table->decimal('half_day_leaves', 5, 2)->nullable()->after('late_attendance_days'); // Half day leaves in hours  -- values have to included in decimal
            $table->decimal('other_deductions', 10, 2)->nullable()->after('half_day_leaves'); // Other deductions   -- values have to included in decimal
            $table->decimal('gross_earnings', 10, 2)->nullable()->after('other_deductions'); // Gross earnings
            $table->decimal('balance_salary', 10, 2)->nullable()->after('gross_earnings'); // Balance salary after deductions
            $table->decimal('employer_epf_contribution', 10, 2)->nullable()->after('balance_salary'); // Employer's EPF contribution
            $table->decimal('etf', 10, 2)->nullable()->after('employer_epf_contribution'); // Employer's ETF contribution
            $table->decimal('total_employer_contribution', 10, 2)->nullable()->after('etf'); // Total employer's contribution
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropColumn([
                'total_pf',
                'gross_salary',
                'informed_absent_days',
                'uninformed_absent_days',
                'late_attendance_days',
                'half_day_leaves',
                'other_deductions',
                'gross_earnings',
                'balance_salary',
                'employer_epf_contribution',
                'etf',
                'total_employer_contribution'
            ]);
        });
    }
};
