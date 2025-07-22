<?php

namespace App\DataTables;
 
use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Support\Facades\Auth;
 
class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable

    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'user.datatables.action')
            ->addColumn('role', function(User $user) {
                $data = $user->getRoleNames();
                return str_replace(["[",'"',"]"], "", $data);
            })
            ->order(function ($query) {
                if (request()->has('id')) {
                    $query->orderBy('id', 'asc');
                }
            })
            ->setRowId('id');
    }
 
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery();
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
                        ...(Auth::user()->can('setting-menu user create') ? [Button::make('add')] : []),
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),

                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload'),
                    ]);
    }
 
    public function getColumns(): array
    {
        return [
            // Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('role'),
            Column::computed('action')
                    ->exportable(false)
                    ->printable(false)
                    ->width(60)
                    ->addClass('text-center'),
        ];
    }
 
    protected function filename(): string
    {
        return 'Users_'.date('YmdHis');
    }
}
