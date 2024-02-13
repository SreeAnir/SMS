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
use App\Models\{Role,EpushServerModel};
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AttendanceDataTable extends DataTable
{
    public $users =[];
    public function __construct()
    {
        $this->users =  User::select(DB::raw('CONCAT(  first_name, " ", last_name) AS name'), 'rfid')
        ->whereNotNull('rfid')
        ->pluck('name', 'rfid')
        ->toArray();
    }
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
    //     ->editColumn('created_at', function ($instance) {
    //         return $instance?->created_at?->format('d/m/Y H:i:s');
    //     })
    //     ->editColumn('other_allowance', function ($instance) {
    //             return $instance?->other_allowance;
    //     })
    //     ->editColumn('location', function ($instance) {
    //         return $instance?->location?->name;
    //     })
    //     ->editColumn('note', function ($instance) {
    //         return $instance->note;  
    //     })
        ->editColumn('name', function ($instance) {
            return $this->users[$instance->UserId];
        })
    //    ->editColumn('email', function ($instance) {
    //     return $instance->user->full_name;
    //     })
    //     ->editColumn('phone', function ($instance) {
    //         return $instance->user->full_phone_number;
    //     })
        // ->editColumn('status_id', function ($instance) {
        //     return view('common.status-badge', compact('instance'));
        // })
        // ->addColumn('action', function ($instance) {
        //         $actions = defaultActions('staff-payments', $instance,['change_status']);
        //         return view('common.actions', compact('actions'));
        // })->
        ->rawColumns(['name']);
    }

    /**
     * Get the query source of dataTable.
     */
    // public function query(): QueryBuilder
    // {
    //     //  $model = new StaffPayment();
    //     //  $externalData =  DB::connection('epushserver')->select($query);
    //     $table_name ="devicelogs_1_2024" ;
    //     $query = "select * from ".$table_name." ";
         
    //     // $query .= " where   DATE(LogDate) = '". $date ."' ";
    //     return  DB::connection('epushserver')->select($query);

    //     // return $table_name->newQuery();
    //     // ->studentType()->latest()->with(['student','status']);
    // }
    public function query()
    { 

        $payload = $this->request->all();
        $customDateOrString =  null;

        if($payload['year']   ){
            if($payload['month'] ==null ){
                $payload['month'] = "01";
            }
            $customDateOrString =  (string)$payload['year']."-".(string)$payload['month']."-"."01" ;
        }

        $modelInstance = new EpushServerModel();
        $tableName =  EpushServerModel::tableName($customDateOrString);
        if (Schema::connection('epushserver')->hasTable($tableName)) {

            $subQuery = $modelInstance->selectRaw('DISTINCT UserId, DATE(LogDate) as LogDate')->from($tableName) ;

            $query =  $modelInstance->from(DB::raw("({$subQuery->toSql()}) as sub"))
            ->mergeBindings($subQuery->getQuery())
            ->groupBy(['UserId', 'LogDate']) ->BranchWise()->newQuery(); ;
 

            /* $query = $modelInstance->on('epushserver')
            
            ->leftJoin(DB::connection('mysql')->raw("`students`"),  'students.id', '=', $tableName.'.UserId')->newQuery(); */

          
           /* $query = $modelInstance->selectRaw('DISTINCT UserId, DATE(LogDate ) as LogDate')
            ->newQuery();  working query
*/

 
               
        }else{
            return (new EpushServerModel())->newQuery()->whereRaw('1 = 0');
        }

        return $query;
    }
    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('attendance-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('attendance.index'), '', [
                        // 'search_key' => "$('#filter_search').val()",
                        'user_id' => "$('#user_id').val()",
                        'created_at' => "$('#created_at').val()", 
                        'year' => "$('#year').val()" ,
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
            // Column::make('id')->hidden(),
            Column::make('LogDate'),
            Column::make('name')->orderable(false),
            Column::make('UserId')->orderable(false)->title('RFID'),
            // Column::make('phone')->orderable(false),
            // Column::make('location')->orderable(false),
            // Column::make('basic_salary'),
            // Column::make('hra')->orderable(false),
            // Column::make('other_allowance')->orderable(false),
            // Column::make('created_at'),
            // Column::computed('action')
            // ->exportable(false)
            // ->printable(false)
            // ->width(60)
            // ->addClass('text-center'),
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
