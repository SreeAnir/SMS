<?php

namespace App\DataTables;

use App\Models\Fee;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Role;
class StudentFeeDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
        ->eloquent($query)
        ->filter(function ($query) {
            $query->filterFromRequest();
        })
        ->addIndexColumn()
        ->editColumn('user', function ($instance) {
            $path =  'students';
            $name =  $instance->user->fullname ;
            $instance = $instance->user ;
            return view('common.column-link', compact('instance' , 'path' , 'name'));

        })
        ->editColumn('installment_nos', function ($instance) {
            return ($instance->installment_nos == 1 ? "One time" : $instance->installment_nos);
        })
        ->editColumn('fee_type', function ($instance) {
            return feeTypelist()[ $instance->fee_type] ;
        })
        ->editColumn('creator', function ($instance) {
            return $instance?->creator->first_name;
        })
        ->editColumn('created_at', function ($instance) {
            return $instance?->created_at?->format('d/m/Y H:i:s');
        })
        ->editColumn('status_id', function ($instance) {
            return view('common.status-badge', compact('instance'));
        })
        ->addColumn('action', function ($instance) {
                $actions = defaultActions('student-fees', $instance,['change_status','edit']);
                return view('common.actions', compact('actions'));
        })
        ->rawColumns([]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Fee $model): QueryBuilder
    {
        return $model->newQuery()->branchWise()->with('user');
        // ->studentType()->latest()->with(['student','status']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('student-fee-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('student-fees.index'), '', [
                        'search_key' => "$('#filter_search').val()",
                        'status_id' => "$('#status_id').val()",
                        'created_at' => "$('#created_at').val()", 
                        'paymet_status' => "$('#paymet_status').val()", 
                        'batch' => "$('#batch').val()", 
                        'student' => "$('#student').val()", 
                        'fee_type' => "$('#fee_type').val()", 
                        'location_id' => "$('#location_id').val()", 
                        'month' => "$('#month').val()", 
                    ])
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
            Column::make('id')->hidden(),
            Column::make('user')->orderable(false),
            Column::make('fee_type'),
            Column::make('amount'),
            Column::make('discount'),
            Column::make('installment_nos'),
            Column::make('creator')->orderable(false),
            Column::make('status_id')->title('Status'),
            Column::make('created_at'),
            Column::make('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'StudentFee_' . date('YmdHis');
    }
}
