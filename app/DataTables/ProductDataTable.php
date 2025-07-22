<?php

namespace App\DataTables;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;

class ProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('image', function ($row) {
                // Assuming the Product model has an `image` attribute with the file path
                $imageUrl = asset('storage/uploads/products/images/' . $row->image); // Adjust path if necessary
                return '<img src="' . $imageUrl . '" alt="' . $row->name . '" width="50" height="50">';
            })
            ->addColumn('unit_name', function ($row) {
                return $row->defaultDisplayProductPrice->productunit->name ? $row->defaultDisplayProductPrice->productunit->name : '-';
            })
            ->addColumn('stock', function ($row) {
                return $row->defaultDisplayProductPrice->unit_conversion_value ? $row->defaultDisplayProductPrice->unit_conversion_value * $row->stock : $row->stock;  
            })
            ->addColumn('action', 'product.datatables.action')
            ->order(function ($query) {
                // if (request()->has('id')) {
                // }
                $query->orderBy('id', 'desc');
            })
            ->rawColumns(['image', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model->newQuery()->with('defaultDisplayProductPrice');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('product-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        ...(Auth::user()->can('master-menu product create') ? [Button::make('add')] : []),
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
            Column::make('id'),
            Column::computed('image')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
            Column::make('code'),
            Column::make('name'),
            Column::make('description'),
            Column::make('stock'),
            Column::make('unit_name')->title('Unit'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            // Column::make('created_at'),
            // Column::make('updated_at'),
            // Column::make('action'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Product_' . date('YmdHis');
    }
}
