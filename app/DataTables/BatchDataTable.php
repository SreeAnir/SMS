<?php

namespace App\DataTables;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BatchDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    
    public function dataTable(QueryBuilder $query): EloquentDataTable
{
    $query = $query->join('locations', 'batches.location_id', '=', 'locations.id') // Perform the join here
            ->select('batches.*', 'locations.name');

        return datatables()
            ->eloquent($query)
            ->filter(function ($query) {
                $query->filterFromRequest();
            })
            ->addColumn('batch_name', function ($instance) {
              if( auth()->user()->can(Batch::PERMISSION_BATCH_UPDATE)){
                return "<a alt='quick edit' role='button' data-id='".$instance->id."' class='edit-batch'>".$instance->batch_name.
                '<span class="mx-1 text-info"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
              </svg></span>'." </a>";
            }else{
                return $instance->batch_name;   
            }


            })
            ->editColumn('status_id', function ($instance) {
                return view('common.status-badge', compact('instance'));
            })
            ->addColumn('batch_time', function ($instance) {
                return $instance->batch_time;
            })
            ->addColumn('name', function ($instance) {
                return $instance->name; // Access location_name from the joined table
            })
            ->addColumn('action', function ($instance) {
                $actions = defaultActions('batches', $instance,['edit']);
                return view('common.actions', compact('actions'));
            })
            ->rawColumns(['batch_name', 'batch_time', 'location_name', 'action'])
            ->addIndexColumn();
}

    /**
     * Get the query source of dataTable.
     */
    public function query(Batch $model): QueryBuilder
    {
        return $model->newQuery()->branchWise();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('batch-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
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
            Column::make('batch_name')->title('Batch')->orderable(false),
            Column::make('name')->title('Location')->orderable(false),
            Column::make('batch_time')->title('Batch Time')->orderable(false),
            Column::make('status_id')->title('Status'),
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
        return 'Batches_' . date('YmdHis');
    }
}
