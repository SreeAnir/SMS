<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class StaffDataTable extends DataTable
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
            // $query->filterFromRequest();
        })
        ->addIndexColumn()
        ->editColumn('created_at', function ($instance) {
            return $instance?->created_at?->format('d/m/Y H:i:s');
        })
        ->editColumn('name', function ($instance) {
             return $instance->full_name;
        })
        ->editColumn('location', function ($instance) {
            return $instance->location?->name;
       })
        ->editColumn('phone', function ($instance) {
            return $instance->full_phone_number;
        })
       
        ->editColumn('status_id', function ($instance) {
            return view('common.status-badge', compact('instance'));
        })
        ->addColumn('action', function ($instance) {
            $actions = defaultActions('staffs', $instance );
            // $actions = defaultActions('users', $instance);
            return view('common.actions', compact('actions'));
        })->
        rawColumns(['name', 'phone']);

        // return (new EloquentDataTable($query))
        //     ->addColumn('action', 'users.action')
        //     ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->staff()->branchWise();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    // ->orderBy(0)
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
            Column::make('name'),
            Column::make('email'),
            Column::make('location')->orderable(false),
            Column::make('phone')->orderable(false),
            // Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('status_id')->title('Status'),
            Column::make('updated_at'),
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
