@extends('layouts.master')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Payslip Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Payslip Data</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Employee Payslip Data</h4>
                            <div class="card-header-action">
                                <a href="{{ route('payslip.create') }}" class="btn btn-primary">+ Create New Payslip</a>
                            </div>
                        </div>
                        <div class="card-body">
                            {{-- Filtering Form --}}
                            <form method="GET" id="filter-form">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label for="emp_no">Filter by Employee No:</label>
                                        <input type="text" name="emp_no" class="form-control" id="emp_no" value="{{ request()->get('emp_no') }}">
                                    </div>
                                    {{-- <div class="col">
                                        <label for="emp_name">Filter by Employee Name:</label>
                                        <input type="text" name="emp_name" class="form-control" id="emp_name" value="{{ request()->get('emp_name') }}">
                                    </div> --}}
                                    
                                    {{-- Month Range Filter --}}
                                    {{-- Added two fields for start and end month to filter by a range --}}
                                    <div class="col">
                                        <label for="start_month">Filter by Start Month:</label>
                                        <input type="month" name="month_from" class="form-control" id="month_from" value="{{ request()->get('month_from') }}">
                                    </div>
                                    <div class="col">
                                        <label for="end_month">Filter by End Month:</label>
                                        <input type="month" name="month_to" class="form-control" id="month_to" value="{{ request()->get('month_to') }}">
                                    </div>
                            
                                    <div class="col align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            

                            {{-- Render the DataTable --}}
                            {{ $dataTable->table(['class' => 'table table-striped table-bordered', 'id' => 'payslip-table']) }}

                            {{-- Section to display totals with cards --}}
                            <div class="row justify-content-center">
                                @foreach ([
                                    'total_gross_salary' => ['label' => 'TOTAL GROSS SALARY', 'color' => 'bg-warning', 'darker' => '#FFA500'],
                                    'total_incentives' => ['label' => 'INCENTIVES', 'color' => 'bg-info', 'darker' => '#1E90FF', 'sub_data' => [
                                        'Attendance' => 'total_attendance_incentive',
                                        'Other' => 'total_other_incentive'
                                    ]],
                                    'total_total_employer_contribution' => ['label' => 'EMPLOYER CONTRIBUTION', 'color' => 'bg-success', 'darker' => '#98FB98', 'sub_data' => [
                                        'EPF' => 'total_employer_epf_contribution',
                                        'ETF' => 'total_etf'
                                    ]],
                                    'total_ot_pay' => ['label' => 'OT PAY', 'color' => 'bg-secondary', 'darker' => '#A9A9A9', 'sub_data' => [
                                        'Normal OT' => 'total_normal_ot_pay',
                                        'Double OT' => 'total_double_ot_pay'
                                    ]]
                                ] as $key => $item)
                                    <div class="col-md-3">
                                        <div class="card {{ $item['color'] }} h-100 text-center" style="margin: 10px; padding: 10px;">
                                            <div class="card-body d-flex flex-column justify-content-center align-items-center" style="padding: 10px;">
                                                <!-- Centered Main Card Title and Value -->
                                                <h5 class="card-title" style="font-size: 1.1rem; color: black; font-weight: bold;">
                                                    {{ $item['label'] }}
                                                </h5>
                                                
                                                <p class="card-text h4" style="font-size: 1.5rem; color: black; font-weight: bold; margin: 10px 0;">
                                                    {{ number_format($totals[$key], 2) }}
                                                </p>
                                    
                                                <!-- Nested Cards Section -->
                                                @if (isset($item['sub_data']))
                                                    <div class="row w-100">
                                                        @foreach ($item['sub_data'] as $sub_label => $sub_key)
                                                            <div class="col-6">
                                                                <div class="card text-center" style="background-color: {{ $item['darker'] }}; color: black; margin: 5px 0; padding: 5px;">
                                                                    <div class="card-body d-flex flex-column justify-content-center align-items-center" style="padding: 8px;">
                                                                        <!-- Nested Card Label -->
                                                                        <h6 class="card-title" style="font-size: 0.85rem; color: black; margin: 0;">
                                                                            {{ $sub_label }}
                                                                        </h6>
                                                                        
                                                                        <!-- Nested Card Value -->
                                                                        <p class="card-text" style="font-size: 1rem; color: black; font-weight: bold; margin: 5px 0;">
                                                                            {{ number_format($totals[$sub_key], 2) }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                @endforeach
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    {{-- Initialize the DataTable script --}}
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
