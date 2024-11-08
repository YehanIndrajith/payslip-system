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
            $table->decimal('informed_absent_days_count', 10, 2)->nullable()->after('informed_absent_days'); // Replace 'existing_column' with the last column in your table
            $table->decimal('uninformed_absent_days_count', 10, 2)->nullable()->after('uninformed_absent_days');
            $table->decimal('late_attendance_days_count', 10, 2)->nullable()->after('late_attendance_days');
            $table->decimal('half_day_leaves_count', 10, 2)->nullable()->after('half_day_leaves');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payslips', function (Blueprint $table) {
            $table->dropColumn(['informed_absent_days_count', 'uninformed_absent_days_count', 'late_attendance_days_count', 'half_day_leaves_count']);
        });
    }
};
