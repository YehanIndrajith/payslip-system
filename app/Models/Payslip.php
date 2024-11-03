<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    protected $table = 'payslips';
    protected $fillable = ['emp_no', 'total_earnings', 'deductions', 'net_salary'];

    // Define inverse relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'emp_no', 'emp_no');
    }

}
