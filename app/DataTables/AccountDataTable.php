<?php

namespace App\DataTables;

use App\Models\Account;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AccountDataTable extends DataTable
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
            ->addColumn('actions', function ($query) {
                return view('client.account.table.actions', compact('query'))->render();
            })
            ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Account  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Account $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('account-table')
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
            [
                'data' => 'account_number',
                'title' => 'Account Number',
            ],
            [
                'data' => 'type',
                'title' => 'Account type',
            ],
            [
                'data' => 'created_at',
                'title' => 'Date Added',
            ],
            Column::computed('actions')
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
        return 'Account_'.date('YmdHis');
    }
}
