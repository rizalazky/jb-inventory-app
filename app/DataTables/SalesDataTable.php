<?php

namespace App\DataTables;
 
use App\Models\Sales;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
 
class SalesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'sales.datatables.action')
            ->rawColumns(['action'])
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'asc');
                }
            })
            ->setRowId('id');
    }
 
    public function query(Sales $model): QueryBuilder
    {
        return $model->where('supplier_id',$this->supplier_id)->newQuery();
    }
 
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('sales-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([]);
    }
 
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('phone'),
            Column::make('address'),
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    // ->width(100)
                    ->addClass('text-center'),
        ];
    }
 
    protected function filename(): string
    {
        return 'Sales_'.date('YmdHis');
    }
}
