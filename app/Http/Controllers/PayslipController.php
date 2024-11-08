<?php

namespace App\Http\Controllers;

use App\DataTables\PayslipDataTable;
use Illuminate\Http\Request;
use App\Models\Payslip;
use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use PDF;

class PayslipController extends Controller
{
    /**
     * Display a listing of the payslips.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PayslipDataTable $dataTable, Request $request)
    {

         $monthFrom = $request->get('month_from');
        $monthTo = $request->get('month_to');

        // Define an array of filters to set
        $filters = [
            'emp_no' => $request->get('emp_no'),
            'emp_name' => $request->get('emp_name'),
          //  'month' => $request->get('month'),
            'base_salary' => $request->get('base_salary'),
            // Add other filters as necessary
            
        ];

       
        
        // Set each filter
        foreach ($filters as $column => $value) {
            if ($value) {
                $dataTable->setFilter($column, $value);
            }
        }

        // Calculate the total sums for relevant columns based on filters
        // Retrieve filtered payslips
        $filteredPayslips = Payslip::query();

       
    // Apply filters to the query
    foreach ($filters as $column => $value) {
        if ($value) {
            $filteredPayslips->where($column, $value);
        }
    }

    // Apply the month range filter if set
    if ($monthFrom && $monthTo) {
        $filteredPayslips->whereBetween('month', [$monthFrom, $monthTo]);
    }

        // Get the total sums for each relevant column
        $totals = [
            'total_base_salary' => $filteredPayslips->sum('base_salary'),
            'total_attendance_incentive' => $filteredPayslips->sum('attendance_incentive'),
            'total_other_incentive' => $filteredPayslips->sum('other_incentive'),
            'total_gross_salary' => $filteredPayslips->sum('gross_salary'),
            'total_net_salary' => $filteredPayslips->sum('net_salary'),
             'total_normal_ot_pay' => $filteredPayslips->sum('normal_ot_pay'),
             'total_double_ot_pay' => $filteredPayslips->sum('double_ot_pay'),
             'total_employer_epf_contribution' => $filteredPayslips->sum('employer_epf_contribution'),
             'total_etf' => $filteredPayslips->sum('etf'),
             'total_total_employer_contribution' => $filteredPayslips->sum('total_employer_contribution'),
             'total_ot_pay' => $filteredPayslips->sum('normal_ot_pay') + $filteredPayslips->sum('double_ot_pay'),
             'total_incentives' => $filteredPayslips->sum('attendance_incentive') + $filteredPayslips->sum('other_incentive'),
            // Add other columns as necessary
        ];

        // Render the DataTable and pass the totals to the view
        return $dataTable->with([
            'month_from' => $monthFrom,
            'month_to' => $monthTo,
            'filters' => $filters
        ])->render('payslip.index', compact('totals'));
    }

    /**
     * Show the form for creating a new payslip.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payslip.create');
    }

    /**
     * Store a newly created payslip in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'emp_no' => 'required|numeric',
            'emp_name' => 'required|string',
            'month' => 'required|date_format:Y-m',
            'basic_salary' => 'required|numeric|min:0',
            'attendance_incentive' => 'nullable|numeric|min:0',
            'other_incentive' => 'nullable|numeric|min:0',
            'before835Incentive' => 'nullable|numeric|min:0',
            'normal_ot_hours' => 'nullable|numeric|min:0',
            'double_ot_hours' => 'nullable|numeric|min:0',
            'epf_rate' => 'nullable|numeric|min:0|max:100', // e.g., 8 for 8%
            'emp_epf_rate' => 'nullable|numeric|min:0|max:100', // e.g., 12 for 12%
            'etf_rate' => 'nullable|numeric|min:0|max:100', // e.g., 3 for 3%
            'salary_advance' => 'nullable|numeric|min:0',
            'informed_absent_days' => 'nullable|numeric|min:0',
            'uninformed_absent_days' => 'nullable|numeric|min:0',
            'late_days' => 'nullable|numeric|min:0',
            'half_day_leave_hours' => 'nullable|numeric|min:0',
            'other_deductions' => 'nullable|numeric|min:0',
            'informed_absent_days_count' => 'nullable|numeric|min:0',
            'uninformed_absent_days_count' => 'nullable|numeric|min:0',
            'late_attendance_days_count' => 'nullable|numeric|min:0',
            'half_day_leaves_count' => 'nullable|numeric|min:0',
        ]);
    
        // Extract the validated data
        $basicSalary = $validatedData['basic_salary'];
        $attendanceIncentive = $validatedData['attendance_incentive'] ?? 0;
        $otherIncentive = $validatedData['other_incentive'] ?? 0;
        $before835Incentive = $validatedData['before835Incentive'] ?? 0;
        $pfTotal = $basicSalary + $attendanceIncentive + $otherIncentive + $before835Incentive;
    
        $otRate = 250;
        $normalOtHours = $validatedData['normal_ot_hours'] ?? 0;
        $doubleOtHours = $validatedData['double_ot_hours'] ?? 0;
    
        // OT Calculations
        $normalOtPay = $normalOtHours * $otRate;
        $doubleOtPay = $doubleOtHours * $otRate * 2;
    
        // Total earnings calculation (gross salary)
        $totalEarnings = $pfTotal + $normalOtPay + $doubleOtPay;
    
        $epfRate = $validatedData['epf_rate'] ?? 8;
        $emp_epfRate = $validatedData['emp_epf_rate'] ?? 12;
        $etfRate = $validatedData['etf_rate'] ?? 3;
    
        $salaryAdvance = $validatedData['salary_advance'] ?? 0;
        $informedAbsentDays = $validatedData['informed_absent_days'] ?? 0;
        $uninformedAbsentDays = $validatedData['uninformed_absent_days'] ?? 0;
        $lateDays = $validatedData['late_days'] ?? 0;
        $halfDayLeaveHours = $validatedData['half_day_leave_hours'] ?? 0;
        $otherDeductions = $validatedData['other_deductions'] ?? 0;
    
        // New Fields
        $informedAbsentDaysCount = $validatedData['informed_absent_days_count'] ?? 0;
        $uninformedAbsentDaysCount = $validatedData['uninformed_absent_days_count'] ?? 0;
        $lateAttendanceDaysCount = $validatedData['late_attendance_days_count'] ?? 0;
        $halfDayLeavesCount = $validatedData['half_day_leaves_count'] ?? 0;
    
        // Deductions calculation
        $epf = $basicSalary * ($epfRate / 100);
        $absentDeductions = ($informedAbsentDays + $uninformedAbsentDays);
        $lateDeductions = $lateDays;
        $halfDayDeductions = $halfDayLeaveHours;
        $totalDeductions = $epf + $absentDeductions + $lateDeductions + $halfDayDeductions + $salaryAdvance + $otherDeductions;
    
        // Calculate net salary
        $netSalary = $totalEarnings - $totalDeductions;
    
        // Employer contributions
        $emp_epf = $basicSalary * ($emp_epfRate / 100);
        $etf = $basicSalary * ($etfRate / 100);
        $totalEmployerContribution = $emp_epf + $etf;
    
        // Create a new payslip entry
        $payslip = new Payslip();
        $payslip->emp_no = $validatedData['emp_no'];
        $payslip->emp_name = $validatedData['emp_name'];
        $payslip->month = $validatedData['month'];
        $payslip->base_salary = $basicSalary;
        $payslip->attendance_incentive = $attendanceIncentive;
        $payslip->other_incentive = $otherIncentive;
        $payslip->before835Incentive = $before835Incentive;
        $payslip->total_pf = $pfTotal;
        $payslip->normal_ot_hours = $normalOtHours;
        $payslip->double_ot_hours = $doubleOtHours;
        $payslip->normal_ot_pay = $normalOtPay;
        $payslip->double_ot_pay = $doubleOtPay;
        $payslip->gross_salary = $totalEarnings;
        $payslip->epf = $epf;
        $payslip->salary_advance = $salaryAdvance;
        $payslip->informed_absent_days = $informedAbsentDays;
        $payslip->uninformed_absent_days = $uninformedAbsentDays;
        $payslip->late_attendance_days = $lateDeductions;
        $payslip->half_day_leaves = $halfDayLeaveHours;
        $payslip->other_deductions = $otherDeductions;
        $payslip->total_deductions = $totalDeductions;
        $payslip->net_salary = $netSalary;
        $payslip->employer_epf_contribution = $emp_epf;
        $payslip->etf = $etf;
        $payslip->gross_earnings = $totalEarnings;
        $payslip->total_employer_contribution = $totalEmployerContribution;
    
        // New Fields
        $payslip->informed_absent_days_count = $informedAbsentDaysCount;
        $payslip->uninformed_absent_days_count = $uninformedAbsentDaysCount;
        $payslip->late_attendance_days_count = $lateAttendanceDaysCount;
        $payslip->half_day_leaves_count = $halfDayLeavesCount;
    
        // Save to database
        $payslip->save();
    
        // Redirect with success message
        return redirect()->route('payslip.index')->with('success', 'Payslip created successfully.');
    }
    

    /**
     * Show the payslip for a specific employee.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function show(Payslip $payslip)
    {
        return view('payslip.show', compact('payslip'));
    }

    /**
     * Show the form for editing the specified payslip.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function edit(Payslip $payslip)
    {
        return view('payslip.edit', compact('payslip'));
    }

    /**
     * Update the specified payslip in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payslip $payslip)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'emp_no' => 'required|numeric|max:255',
            'emp_name' => 'required|string',
            'month' => 'required|date_format:Y-m',
            'base_salary' => 'required|numeric|min:0',
            // Include other fields as necessary
        ]);

        // Update the payslip with the new data
        $payslip->update($validatedData);

        return redirect()->route('payslip.index')->with('success', 'Payslip updated successfully.');
    }

    /**
     * Remove the specified payslip from storage.
     *
     * @param  \App\Models\Payslip  $payslip
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payslip $payslip)
    {
        $payslip->delete();

        return redirect()->route('payslip.index')->with('success', 'Payslip deleted successfully.');
    }

    public function generatePdf($id)
    {
        $payslip = Payslip::findOrFail($id);
    
        $pdf = PDF::loadView('payslip.pdf', compact('payslip'));
    
        return $pdf->download('payslip_' . $payslip->emp_no . '_' . $payslip->month . '.pdf');

    }
    
    // You may want to add methods for exporting PDFs, etc.
}
