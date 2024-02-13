<?php

namespace App\DataTables;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use App\Models\Role;
use App\Models\Accounting;
use Carbon\Carbon ;
class AccountingDataTable extends DataTable
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
        ->editColumn('acc_type', function ($instance) {
            return view('common.account-badge', compact('instance'));
        })
         
        ->orderColumn('category', function ($query, $order) {
            $query->orderBy('category_id', $order);
        })
        ->orderColumn('acc_type', function ($query, $order) {
            $query->orderBy('acc_type', $order);
        })
        ->orderColumn('date', function ($query, $order) {
            $query->orderBy('date', $order);
        })
        ->editColumn('amount', function ($instance) {
            $instance =  $instance ;
            return view('admin.accounting.partials.amount', compact('instance'));
        })
        ->editColumn('category', function ($instance) {
            if( $instance->deleted_at !=null){
                return  '<i class="fas fa-trash text-danger"></i><span class="text-muted"> '.$instance->category->category_label."</span>" ;
            }
            return  $instance->category->category_label ;
        })
        ->editColumn('date', function ($instance) {
            return  ($instance?->date !="" ? Carbon::parse($instance?->date)->format('d/m/Y') : "");
        })
        ->editColumn('location', function ($instance) {
            return $instance->location?->name ;
        })
        
        ->editColumn('created_at', function ($instance) {
            return $instance?->created_at?->format('d/m/Y H:i:s');
        })
        ->addColumn('action', function ($instance) {
            $actions = defaultActions('accounting', $instance);
            return view('common.actions', compact('actions'));
        })->
        rawColumns(['name', 'phone','category']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Accounting $model): QueryBuilder
    {
        return $model->newQuery()->withTrashed();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('accountings-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('accounting.index'), '', [
                        'search_key' => "$('#filter_search').val()",
                        'status_id' => "$('#status_id').val()",
                        'created_at' => "$('#created_at').val()", 
                        'income' =>  "$('#income_checkbox').is(':checked')", 
                        'expense' =>  "$('#expense_checkbox').is(':checked')", 
                        'month' =>  "$('#month').val()", 
                        'date' =>  "$('#date').val()", 
                        'date_from' =>  "$('#date_from').val()", 
                        'date_to' =>  "$('#date_to').val()", 
                        'category_id' => "$('#category_id').val()",
                        'location_id' => "$('#location_id').val()",
                    ])
                    ->selectStyleSingle()
                    ->orderBy(6, 'desc')
                    ;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->hidden(),
            Column::make('acc_type'),
            Column::make('category')->orderable(false),
            Column::make('amount'),
            Column::make('location')->orderable(false),
            Column::make('date'),
            Column::make('created_at'),
            Column::computed('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Accountings_' . date('YmdHis');
    }
}
