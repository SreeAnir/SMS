<?php

namespace App\DataTables;

use App\Models\StaffPayment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Role;
class StaffPaymentDataTable extends DataTable
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
        ->editColumn('created_at', function ($instance) {
            return $instance?->created_at?->format('d/m/Y H:i:s');
        })
        ->editColumn('other_allowance', function ($instance) {
                return $instance?->other_allowance;
        })
        ->editColumn('location', function ($instance) {
            return $instance?->location?->name;
        })
        ->editColumn('note', function ($instance) {
            return $instance->note;  
        })
        ->editColumn('name', function ($instance) {
            return $instance->user->full_name;
       })
       ->editColumn('email', function ($instance) {
        return $instance->user->full_name;
        })
        ->editColumn('phone', function ($instance) {
            return $instance->user->full_phone_number;
        })
        // ->editColumn('status_id', function ($instance) {
        //     return view('common.status-badge', compact('instance'));
        // })
        ->addColumn('action', function ($instance) {
                $actions = defaultActions('staff-payments', $instance,['change_status']);
                return view('common.actions', compact('actions'));
        })->
        rawColumns(['name', 'phone']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(StaffPayment $model): QueryBuilder
    {
        return $model->newQuery();
        // ->studentType()->latest()->with(['student','status']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('staff-payment-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('staff-payments.index'), '', [
                        'search_key' => "$('#filter_search').val()",
                        'staff_id' => "$('#staff_id').val()",
                        'location_id' => "$('#location_id').val()",
                        'created_at' => "$('#created_at').val()", 
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
            Column::make('name')->orderable(false),
            Column::make('email')->orderable(false),
            Column::make('phone')->orderable(false),
            Column::make('location')->orderable(false),
            Column::make('basic_salary'),
            Column::make('hra')->orderable(false),
            Column::make('other_allowance')->orderable(false),
            Column::make('created_at'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
