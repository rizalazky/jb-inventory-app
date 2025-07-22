<?php

namespace App\DataTables;
 
use App\Models\Stock;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;
 
class StockDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable

    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'stock.datatables.action')
            ->order(function ($query) {
                if (request()->has('id')) {
                }
                $query->orderBy('id', 'desc');
            })
            ->setRowId('id');
    }
 
    public function query(Stock $model): QueryBuilder
    {
        $can_read_stock_in = Auth::user()->can('stock-menu stock-in read');
        $can_read_stock_out = Auth::user()->can('stock-menu stock-out read');
        $query = $model->with('product','productprice.productunit','user')->newQuery();

        if ($can_read_stock_in && !$can_read_stock_out) {
            // Hanya bisa lihat transaksi masuk
            $query->where('type', 'in');
        }
        if (!$can_read_stock_in && $can_read_stock_out) {
            // Hanya bisa lihat transaksi keluar
            $query->where('type', 'out');
        }
        return $query;
    }
 
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        // Button::make('add'),
                        // Button::make('excel'),
                        // Button::make('csv'),
                        // Button::make('pdf'),

                        // Button::make('print'),
                        // Button::make('reset'),
                        // Button::make('reload'),
                    ]);
    }
 
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::computed('product')
                        ->title('Product')
                        ->data('product.name') // Assuming 'name' is the field you want to display from the Product model
                        ->name('product.name'),
            Column::make('quantity'),
            Column::computed('productprice')
                        ->title('Satuan')
                        ->data('productprice.productunit.name') // Assuming 'name' is the field you want to display from the Product model
                        ->name('productprice.productunit.name'),
            Column::make('type'),
            Column::make('notes'),
            Column::computed('users')
                    ->title('User')
                    ->data('user.name')
                    ->name('user.name'),
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
        ];
    }
 
    protected function filename(): string
    {
        return 'Stocks_'.date('YmdHis');
    }
}
