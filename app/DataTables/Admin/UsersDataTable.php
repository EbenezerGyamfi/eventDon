<?php

namespace App\DataTables\Admin;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('email_verified', function ($user) {
                return is_null($user->email_verified_at) ? 'No' : 'Yes';
            })
            ->editColumn('phone_number_verified', function ($user) {
                return $user->phone_number_verified === '1' ? 'Yes' : 'No';
            })
            ->editColumn('created_at', function ($user) {
                return $user->created_at->toDateTimeString();
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.table.actions', [
                    'query' => $user,
                ]);
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->where('role', 'client')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('admin-users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
        // ->buttons(
        //     Button::make('create'),
        //     Button::make('export'),
        //     Button::make('print'),
        //     Button::make('reset'),
        //     Button::make('reload')
        // );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name'),
            Column::make('email'),
            Column::make('phone'),
            Column::make('email_verified')
                ->searchable(false),
            Column::make('phone_number_verified')
                ->searchable(false),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-right d-flex flex-row justify-content-center align-items-center account-actions'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Admin_Users_'.date('YmdHis');
    }
}
