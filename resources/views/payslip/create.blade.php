@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Create Payslip</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Components</a></div>
            <div class="breadcrumb-item">Payslip Data</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row justify-content-center">
            <!-- Payslip Details Card -->
            <div class="col-md-8">
                <div class="card mx-auto" style="width: 100%;">
                    <div class="card-header">
                        <h4 style="color: darkblue;">Enter Payslip Details</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('payslip.store') }}" method="POST" id="payslip-form">
                            @csrf

                            <!-- Employee Search Section -->
                            <div class="form-group">
                                <label>Employee No / Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="emp_search" name="emp_search" placeholder="Enter Employee No or Name" required>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" id="load-employee-btn">Load</button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Employee No</label>
                                <input type="text" class="form-control" id="emp_no" name="emp_no" required readonly>
                            </div>

                            <div class="form-group">
                                <label>Employee Name</label>
                                <input type="text" class="form-control" id="emp_name" name="emp_name" required readonly>
                            </div>

                            <div class="form-group">
                                <label>Month</label>
                                <input type="month" class="form-control" name="month" required>
                            </div>

                            <!-- Earnings Section -->
                            <h5 class="mt-4" style="color: darkblue;">Earnings</h5>
                            <div class="form-row">
                                <div class="col-md-4">
                                    <label>Basic Salary</label>
                                    <input type="number" class="form-control" id="basic_salary" name="basic_salary" required readonly>
                                </div>
                                <div class="col-md-4">
                                    <label>Attendance Incentive</label>
                                    <input type="number" class="form-control" name="attendance_incentive">
                                </div>
                                <div class="col-md-4">
                                    <label>Other Incentive</label>
                                    <input type="number" class="form-control" name="other_incentive">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Before 8.35 AM Incentive</label>
                                <input type="number" class="form-control" name="before835Incentive">
                            </div>

                            {{-- <div class="form-group mt-3">
                                <label>Before 8.35 AM Incentive</label>
                                <select class="form-control" name="incentive_835am">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div> --}}

                            {{-- <div class="form-group">
                                <label>Total for PF</label>
                                <input type="number" class="form-control" name="">
                            </div> --}}

                            <!-- Overtime -->
                            <h5 class="mt-4" style="color: darkblue;">Overtime</h5>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label>Normal OT Hours</label>
                                    <input type="number" class="form-control" name="normal_ot_hours">
                                </div>
                                <div class="col-md-6">
                                    <label>Double OT Hours</label>
                                    <input type="number" class="form-control" name="double_ot_hours">
                                </div>
                            </div>

                              <!-- Deductions Section -->
<h5 class="mt-4" style="color: darkblue;">Deductions</h5>
<div class="form-row">
    <div class="col-md-6">
        <label>EPF</label>
        <input type="number" class="form-control" name="epf" readonly>
    </div>
    <div class="col-md-6">
        <label>Salary Advance</label>
        <input type="number" class="form-control" name="salary_advance">
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <label>Informed Absent Days</label>
        <input type="number" class="form-control" name="informed_absent_days">
    </div>
    <div class="col-md-6">
        <label>Informed Absent Days Count</label>
        <input type="number" class="form-control" name="informed_absent_days_count">
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <label>Uninformed Absent Days</label>
        <input type="number" class="form-control" name="uninformed_absent_days">
    </div>
    <div class="col-md-6">
        <label>Uninformed Absent Days Count</label>
        <input type="number" class="form-control" name="uninformed_absent_days_count">
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <label>Late Attendance Days</label>
        <input type="number" class="form-control" name="late_days">
    </div>
    <div class="col-md-6">
        <label>Late Attendance Days Count</label>
        <input type="number" class="form-control" name="late_attendance_days_count">
    </div>
</div>
<div class="form-row">
    <div class="col-md-6">
        <label>Half Day Leaves (Hours)</label>
        <input type="number" class="form-control" name="half_day_leave_hours">
    </div>
    <div class="col-md-6">
        <label>Half Day Leaves Count</label>
        <input type="number" class="form-control" name="half_day_leaves_count">
    </div>
</div>
<div class="form-group">
    <label>Other Deductions</label>
    <input type="number" class="form-control" name="other_deductions" required>
</div>


                            <!-- Summary Section -->
                            {{-- <h5 class="mt-4" style="color: darkblue;">Summary</h5>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label>Gross Earnings</label>
                                    <input type="number" class="form-control" name="gross_earnings">
                                </div>
                                <div class="col-md-6">
                                    <label>Balance Salary</label>
                                    <input type="number" class="form-control" name="balance_salary">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label>Employer's EPF Contribution</label>
                                    <input type="number" class="form-control" name="employer_epf_contribution">
                                </div>
                                <div class="col-md-6">
                                    <label>ETF</label>
                                    <input type="number" class="form-control" name="etf">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Total Employer's Contribution</label>
                                <input type="number" class="form-control" name="total_employer_contribution">
                            </div> --}}

                            <div class="form-group mt-4 text-right">
                                <button type="submit" class="btn btn-primary">Create Payslip</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('load-employee-btn').addEventListener('click', function () {
        const searchQuery = document.getElementById('emp_search').value.trim();
    
        if (searchQuery) {
            fetch(`/employee/search/${encodeURIComponent(searchQuery)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Employee not found');
                    }
                    return response.json();
                })
                .then(data => {
                    // Populate fields with the employee data
                    document.getElementById('emp_no').value = data.emp_no;
                    document.getElementById('emp_name').value = data.emp_name;
                    document.getElementById('basic_salary').value = data.emp_base_salary;
    
                    // Ensure inputs are editable
                    document.getElementById('emp_no').removeAttribute('readonly');
                    document.getElementById('emp_name').removeAttribute('readonly');
                    document.getElementById('basic_salary').removeAttribute('readonly');
                })
                .catch(error => {
                    alert(error.message || 'Error occurred.');
                });
        } else {
            alert('Please enter Employee No or Name.');
        }
    });
</script>

@endsection
