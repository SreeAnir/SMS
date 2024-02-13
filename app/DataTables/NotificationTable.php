<?php

namespace App\DataTables;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Role;
class NotificationTable extends DataTable
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
        ->editColumn('title', function ($instance) {
            if($instance?->notification_type == Notification::EVENT){ 
                return $instance?->notifiable->title;
            }
            return $instance?->title;
        })
        ->editColumn('message', function ($instance) {
            return $instance?->message;
        })
        ->editColumn('created_at', function ($instance) {
            return $instance?->created_at?->format('d/m/Y H:i:s');
        })
        ->editColumn('notification_type', function ($instance) {
            return $instance?->notification_type_label;
        })
        ->editColumn('notification_date', function ($instance) {
            return $instance?->notification_date ;
        })
        ->editColumn('status_id', function ($instance) {
            return view('common.status-badge', compact('instance'));
        })
        ->addColumn('action', function ($instance) {
                $actions = defaultActions('notifications', $instance,['change_status']);
                return view('common.actions', compact('actions'));
        })->
        rawColumns(['name', 'phone']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Notification $model): QueryBuilder
    {
        return $model->newQuery()->latest();
        // ->studentType()->latest()->with(['student','status']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('notification-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('notifications.index'), '', [
                        'search_key' => "$('#filter_search').val()",
                        'status_id' => "$('#status_id').val()",
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
            Column::make('title'),
            Column::make('message'),
            Column::make('notification_type'),
            Column::make('notification_date'),
            Column::make('status_id')->title('Status'),
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
