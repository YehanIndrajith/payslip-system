<?php

namespace App\DataTables;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EmployeeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function($query)
            {
            //    $editBtn = "<a href='".route('employees.edit', $query->id)."' class='btn btn-primary'>edit</a>";
               $deleteBtn = "<a href='".route('employees.destroy', $query->id)."' class='btn btn-danger ml-2 delete-item'>delete</a>";

             return $deleteBtn;

            })
            ->addColumn('emp_profile_pic', function($query)
            {
              return  $img = "<img width='100px' src='".asset('uploads/'.$query->emp_profile_pic)."' ></img>";
            })
            ->rawColumns(['emp_profile_pic', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Employee $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('employee-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
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

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
           
            Column::make('id')->width(100),
          //  Column::make('emp_profile_pic')->width(200),
            Column::make('emp_no')->width(100),
            Column::make('emp_name'),
            column::make('emp_address'),
            column::make('emp_base_salary'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(200)
            ->addClass('text-center'),
           
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Employee_' . date('YmdHis');
    }
}
