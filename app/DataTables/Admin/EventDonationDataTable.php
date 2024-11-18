<?php

namespace App\DataTables\Admin;

use App\Models\Event;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventDonationDataTable extends DataTable
{
    public function __construct(private Event $event)
    {
    }

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

        ->editColumn('Phone', function ($event) {
            return $event->phone;
        })

        ->editColumn('Amount', function ($event) {
            return number_format($event->amount,2);
        })

        ->editColumn('Amount After Charges', function ($event) {
            return number_format($this->event->donationTransactions->sum('amount_after_charges'),2);
        })


        ->editColumn('Time', function ($event) {
            return $event->created_at;
        })

        ->rawColumns(['date', 'status', 'date']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\EventDonation  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->event->donations();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('eventdonation-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('Phone')
            ->searchable(false)
            ->orderable(false),
            Column::make('Amount')
            ->searchable(false)
            ->orderable(false),
            Column::make('Amount After Charges')
            ->searchable(false)
            ->orderable(false),
            Column::make('Time')
            ->searchable(false)
            ->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EventDonation_'.date('YmdHis');
    }
}
