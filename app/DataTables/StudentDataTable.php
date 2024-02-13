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
use App\Models\Role;
class StudentDataTable extends DataTable
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
        ->editColumn('batch', function ($instance) {
             if( $instance->student->batches?->count()>0){
               return implode(', ', $instance->student->batches?->pluck('batch_name')->toArray()).
               ', '.$instance?->location?->name ;
             }else{
                return "";
             }
        })
        ->editColumn('kacha', function ($instance) {
            return view('common.kacha-mini-badge', ['instance' => $instance->student] );
            // if( $instance->student->kachaStudents?->count()>0){
            //     $latest =  $instance->student->kachaStudents()->latest()->first();
            //     if($latest != null ){
            //         $current_kacha_class = $latest->class_count;
            //         return  $current_kacha_class ;
            //     }
            // } 
            //    return "";
             
       })
        ->editColumn('name', function ($instance) {
            // return $instance->full_name;
            return view('admin.students.name', compact('instance'));
       })
        ->editColumn('phone', function ($instance) {
            return $instance->full_phone_number;
        })
       
        ->editColumn('status_id', function ($instance) {
            return view('common.status-badge', compact('instance'));
        })
        ->orderColumn('name', function ($query, $order) {
            $query->orderBy('first_name', $order);
        })
        ->addColumn('action', function ($instance) {
            // return $instance->user_type ;
            // if( $instance->user_type == Role::USER_TYPE_STAFF){
            //     $actions = defaultActions('staffs', $instance, ['staffs.edit'] );
            // }else{
                $actions = defaultActions('students', $instance);
            // }
           
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
        return $model->newQuery()->studentType()->branchWise()->with(['student' => function($query){
            $query->select('id','user_id','kacha_id');
        }
        ,'status','student.kachaStudents' => function($query){
            $query->select('id','student_id','kacha_id');
        } ,'student.kacha' => function($query){
            $query->select('id','label','level','color');
        } ,'location' => function($query){
            $query->select('id','name','status_id');
        },'student.batches'  => function($query){
            $query->select( 'batch_name','location_id');
        }]);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    // ->minifiedAjax(route('users.index'), '', [
                    //     'search_key' => "$('#search_key').val()",
                    //     // 'course_order' => "$('#analytics_filter [name=\"course_order\"]').val()",
                    // ])
                    ->minifiedAjax(route('students.index'), '', [
                        'search_key' => "$('#filter_search').val()",
                        'status_id' => "$('#status_id').val()",
                        'kacha_id' => "$('#kacha_id').val()",
                        'class_count' => "$('#class_count').val()",
                        'location_id' => "$('#location_id').val()",
                        'batch_id' => "$('#batch_id').val()",
                    ])
                    // ->minifiedAjax()
                    //->dom('Bfrtip')
                    // ->orderBy(0)
                    ->selectStyleSingle();
                    
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
            Column::make('phone')->orderable(false),
            Column::make('batch')->orderable(false),
            Column::make('kacha')->orderable(false),
            // Column::make('add your columns'),
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
