<?php

namespace App\DataTables;
 
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;
 
class TransactionDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable

    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'transaction.datatables.action')
            ->order(function ($query) {
                // if (request()->has('id')) {
                // }
                $query->orderBy('id', 'desc');
            })
            ->setRowId('id');
    }
 
    public function query(Transaction $model): QueryBuilder
    {
        $can_read_transaction_in = Auth::user()->can('transaction-menu transaction-in read');
        $can_read_transaction_out = Auth::user()->can('transaction-menu transaction-out read');
        $query = $model->with('user','customer','supplier')->newQuery();

        if ($can_read_transaction_in && !$can_read_transaction_out) {
            // Hanya bisa lihat transaksi masuk
            $query->where('type', 'in');
        }
        if (!$can_read_transaction_in && $can_read_transaction_out) {
            // Hanya bisa lihat transaksi keluar
            $query->where('type', 'out');
        }    
        return $query;
    }
 
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('transactions-table')
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
            // Column::make('id'),
            Column::computed('date'),
            Column::computed('transaction_number'),
            Column::computed('customer')
                        ->title('Customer')
                        ->data('customer.name') // Assuming 'name' is the field you want to display from the Product model
                        ->name('customer.name'),
            Column::computed('supplier')
                        ->title('Supplier')
                        ->data('supplier.name') // Assuming 'name' is the field you want to display from the Product model
                        ->name('supplier.name'),
            Column::computed('type'),
            // Column::make('notes'),
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
        return 'Transactions_'.date('YmdHis');
    }
}
