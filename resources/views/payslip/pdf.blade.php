<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payslip</title>
    <style>
        /* Set PDF to A4 size proportions */
        @page { size: A4; margin: 20px; }

        /* General styles */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #333;
            background-color: #ffffff;
        }

        /* Header styles */
        .header {
            text-align: center;
            color: #003366;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .sub-header {
            text-align: center;
            font-size: 12px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Employee info and payslip details */
        .info-table, .earnings-table, .deductions-table, .summary-table, .contributions-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .info-table td, .earnings-table th, .earnings-table td, 
        .deductions-table th, .deductions-table td, .summary-table td, 
        .contributions-table td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .label { background-color: #e1e9f2; font-weight: bold; }
        .amount { font-weight: bold; background-color: #d1e0f0; }
        .count-column { background-color: #d1e0f0; font-weight: bold; } /* Matching color for additional column */

        /* Section headers */
        .section-header {
            background-color: #003366;
            color: white;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            margin-top: 15px;
        }

        /* Highlighted row in the summary section */
        .highlighted {
            background-color: #65a5e4;
            color: #111;
            font-weight: bold;
        }

        /* Footer */
        .footer {
            background-color: #003366;
            color: white;
            padding: 8px;
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Company Details -->
    <div class="header">ASANKA PRINTERS</div>
    <p class="sub-header">480/4, Kohalwila Rd, Gonawala, Kelaniya </p>
    <p class="sub-header">+94 112-908-814 | +94 777-555-399</p>
    <!-- Payslip Title -->
    <div class="section-header">Pay Slip for the Month: {{ $payslip->month }}</div>

    <!-- Employee Info -->
    <table class="info-table">
        <tr>
            <td class="label">Emp No:</td>
            <td>{{ $payslip->emp_no }}</td>
            <td class="label">Name:</td>
            <td>{{ $payslip->emp_name }}</td>
        </tr>
    </table>

    <!-- Earnings Section -->
    <div class="section-header">Earnings</div>
    <table class="earnings-table">
        <tr><td class="label">Basic Salary</td><td class="amount">{{ number_format($payslip->base_salary, 2) }}</td></tr>
        <tr><td class="label">Attendance Incentive</td><td class="amount">{{ number_format($payslip->attendance_incentive, 2) }}</td></tr>
        <tr><td class="label">Other Incentive</td><td class="amount">{{ number_format($payslip->other_incentive, 2) }}</td></tr>
        <tr><td class="label">Total for PF</td><td class="amount">{{ number_format($payslip->total_pf, 2) }}</td></tr>
        <tr><td class="label">Normal OT Pay</td><td class="amount">{{ number_format($payslip->normal_ot_pay, 2) }}</td></tr>
        <tr><td class="label">Double OT Pay</td><td class="amount">{{ number_format($payslip->double_ot_pay, 2) }}</td></tr>
        <tr class="highlighted"><td class="label">Gross Salary</td><td class="amount">{{ number_format($payslip->gross_salary, 2) }}</td></tr>
    </table>

    <!-- Deductions Section -->
    <div class="section-header">Deductions</div>
    <table class="deductions-table">
        <tr>
            <td class="label">EPF</td>
            <td class="count-column">8%</td>
            <td class="amount">{{ number_format($payslip->epf, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Informed Absent Days</td>
            <td class="count-column">{{ $payslip->informed_absent_days_count }}</td>
            <td class="amount">{{ number_format($payslip->informed_absent_days, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Uninformed Absent Days</td>
            <td class="count-column">{{ $payslip->uninformed_absent_days_count }}</td>
            <td class="amount">{{ number_format($payslip->uninformed_absent_days, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Late Attendance Days</td>
            <td class="count-column">{{ $payslip->late_attendance_days_count }}</td>
            <td class="amount">{{ number_format($payslip->late_attendance_days, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Half Day Leaves (Hours)</td>
            <td class="count-column">{{ $payslip->half_day_leaves_count }}</td>
            <td class="amount">{{ number_format($payslip->half_day_leaves, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Salary Advance</td>
            <td class="count-column"></td>
            <td class="amount">{{ number_format($payslip->salary_advance, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Other Deductions</td>
            <td class="count-column"></td>
            <td class="amount">{{ number_format($payslip->other_deductions, 2) }}</td>
        </tr>
        <tr class="highlighted">
            <td class="label">Total Deductions</td>
            <td class="count-column"></td>
            <td class="amount">{{ number_format($payslip->total_deductions, 2) }}</td>
        </tr>
    </table>

    <!-- Summary Section -->
    <div class="section-header">Summary</div>
    <table class="summary-table">
        <tr><td class="label">Gross Earnings</td><td class="amount">{{ number_format($payslip->gross_salary, 2) }}</td></tr>
        <tr><td class="label">Total Deductions</td><td class="amount">{{ number_format($payslip->total_deductions, 2) }}</td></tr>
        <tr class="highlighted"><td class="label">Net Earnings</td><td class="amount">{{ number_format($payslip->net_salary, 2) }}</td></tr>
    </table>

    <!-- Employer Contributions Section -->
    <div class="section-header">Employer Contributions</div>
    <table class="contributions-table">
        <tr><td class="label">EPF (12%)</td><td class="amount">{{ number_format($payslip->employer_epf_contribution, 2) }}</td></tr>
        <tr><td class="label">ETF (3%)</td><td class="amount">{{ number_format($payslip->etf, 2) }}</td></tr>
        <tr class="highlighted"><td class="label">Total Employer's Contribution</td><td class="amount">{{ number_format($payslip->total_employer_contribution, 2) }}</td></tr>
    </table>

    <!-- Footer -->
    <div class="footer">Generated by Asanka Printers Payroll System</div>
</div>

</body>
</html>
