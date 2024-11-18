<?php

namespace App\DataTables;

use App\Models\WalletEvent;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WalletEventsDataTable extends DataTable
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
            ->editColumn('created_at', function (WalletEvent $walletEvent) {
                return $walletEvent->created_at->toDateTimeString();
            });
    }

    /**
     * Get query source of dataTable.
     *
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WalletEvent $model)
    {
        return WalletEvent::whereIn('wallet_id', auth()->user()->wallets()->pluck('id'))
                ->latest('created_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('wallet-events-table')
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
            [
                'data' => 'description',
                'title' => 'Payment Description',
            ],
            [
                'data' => 'transaction_amount',
                'title' => 'Amount',
            ],
            [
                'data' => 'before_balance',
                'title' => 'Before Balance',
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'data' => 'after_balance',
                'title' => 'After Balance',
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'data' => 'type',
                'title' => 'Status',
                'searchable' => false,
                'orderable' => false,
            ],
            [
                'data' => 'created_at',
                'title' => 'Created At',
            ],
            // Column::computed('action')
            //     ->exportable(false)
            //     ->printable(false)
            //     ->width(60)
            //     ->addClass('text-right d-flex flex-row justify-content-center align-items-center account-actions')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ContactGroup_'.date('YmdHis');
    }
}
