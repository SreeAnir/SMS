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
use App\Models\AccountingCategory;

class AccountingCategoryDataTable extends DataTable
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
        ->editColumn('category_type', function ($instance) {
            // return  $instance->category_type_label ;
            return view('common.account-badge', compact('instance'));
        })
        ->editColumn('created_at', function ($instance) {
            return $instance?->created_at?->format('d/m/Y H:i:s');
        })
        ->editColumn('status_id', function ($instance) {
            return view('common.status-badge', compact('instance'));
        })
        ->addColumn('action', function ($instance) { 
                $actions = defaultActions('accounting-categories', $instance,['change_status']);
                return view('common.actions', compact('actions'));
        })->
        rawColumns(['name', 'phone']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(AccountingCategory $model): QueryBuilder
    {
        $model = $model->newQuery()->latest();
            return $model->withTrashed();
        // ->studentType()->latest()->with(['student','status']);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('category-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax(route('accounting-categories.index'), '', [
                        'search_key' => "$('#filter_search').val()",
                        'status_id' => "$('#status_id').val()",
                        'created_at' => "$('#created_at').val()", 
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
            Column::make('category_type')->title('Type'),
            Column::make('category_label')->title('Name'),
            Column::make('category_description')->title('Description'),
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
        return 'Categoies_' . date('YmdHis');
    }
}
