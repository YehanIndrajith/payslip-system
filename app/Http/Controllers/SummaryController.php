<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payslip;
use DB;

class SummaryController extends Controller
{
    public function index()
    {
        $payslips = Payslip::all();

        return view('summary.index', compact('payslips'));
    }
}
