<?php

namespace App\DataTables;

use App\Models\BatchStudent;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Models\Batch;
class BatchStudentDatatable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    protected $batch;

    public function __construct(Batch $batch)
    {
        $this->batch = $batch;
    }
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
     
        return datatables()
            ->eloquent($query)
            ->filter(function ($query) {
                $query->filterFromRequest();
            })
            ->addColumn('student_name', function ($instance) {
                return $instance->student->user->full_name;
            })
            ->addColumn('attendance', function ($instance) {
                return "100%"; //$instance->id;
            })
            ->addColumn('student_phone', function ($instance) {
                return $instance->student->user->full_phone_number;
            })
            ->addColumn('action', function ($instance) {
                
                return ('<a target="_blank" class="text-info" href="'. route('students.show',[$instance->student->user_id]) .'">
                <i class="me-2 mdi mdi-eye"></i>View</a>');
            })
            ->rawColumns([ 'action'])
            ->addIndexColumn();
}

    /**
     * Get the query source of dataTable.
     */
    public function query(BatchStudent $model): QueryBuilder
    { 
        return $model->newQuery()->where('batch_id', $this->batch?->id )->with(['student','batch']);
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
            Column::make('student_name')->title('Student Name')->sortable(),
            Column::make('attendance')->title('Attendance %'),
            Column::make('student_phone')->title('Phone'),
            // Column::make('batch_time')->title('Batch Time'),
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
