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
            $table->text('emp_profile_pic')->nullable();
            $table->integer('emp_no')->nullable();
            $table->string('emp_name')->nullable();
            $table->string('emp_address')->nullable();
            $table->decimal('emp_base_salary')->nullable();
            $table->boolean('emp_status')->nullable();
            $table->timestamps();
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
