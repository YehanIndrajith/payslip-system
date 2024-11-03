<?php

namespace App\DataTables;

use App\Models\Payslip;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PayslipDataTable extends DataTable
{
    protected $filters = [];

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return '<a href="' . route('payslip.pdf', $row->id) . '" class="btn btn-sm btn-primary">Download PDF</a>';
            })
            ->setRowId('id')
            ->rawColumns(['action']);
    }

    public function query(Payslip $model): QueryBuilder
    {
        $query = $model->newQuery();

        if ($this->request()->has('month_from') && $this->request()->has('month_to')) {
            $monthFrom = $this->request()->get('month_from');
            $monthTo = $this->request()->get('month_to');
            $query->whereBetween('month', [$monthFrom, $monthTo]);
        }

        // Apply all filters dynamically
        foreach ($this->filters as $column => $value) {
            if ($value) {
                $query->where($column, 'LIKE', "%{$value}%");
            }
        }


        return $query;
    }

    // Set a filter for a specific column
    public function setFilter($column, $value)
    {
        $this->filters[$column] = $value;
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('payslip-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->scrollX(true)
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('emp_no')->width(20),
            Column::make('emp_name')->width(30),
            Column::make('month')->width(20),
            Column::make('base_salary')->width(20),
            Column::make('attendance_incentive')->width(30),
            Column::make('other_incentive')->width(30),
            Column::make('before835Incentive')->width(30),
            Column::make('total_pf')->width(30),
            Column::make('normal_ot_hours')->width(250),
            Column::make('double_ot_hours')->width(250),
            Column::make('normal_ot_pay')->width(250),
            Column::make('double_ot_pay')->width(250),
            Column::make('gross_salary')->width(150),
            Column::make('epf')->width(30),
            Column::make('salary_advance')->width(30),
            Column::make('informed_absent_days')->width(400),
            Column::make('uninformed_absent_days')->width(320),
            Column::make('late_attendance_days')->width(400),
            Column::make('half_day_leaves')->width(380),
            Column::make('other_deductions')->width(220),
            Column::make('gross_earnings')->width(50),
            Column::make('total_deductions')->width(50),
            Column::make('net_salary')->width(30),
            Column::make('employer_epf_contribution')->width(280),
            Column::make('etf')->width(30),
            Column::make('total_employer_contribution')->width(400),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    protected function filename(): string
    {
        return 'Payslip_' . date('YmdHis');
    }
}
