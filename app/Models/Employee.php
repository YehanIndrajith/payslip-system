<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = ['emp_no', 'emp_name', 'emp_base_salary'];

    // Define relationship with Payslip
    public function payslips()
    {
        return $this->hasMany(Payslip::class, 'emp_no', 'emp_no');
    }
}
