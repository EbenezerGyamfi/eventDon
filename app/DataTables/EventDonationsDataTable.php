<?php

namespace App\DataTables;

use App\Models\Event;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventDonationsDataTable extends DataTable
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
            ->collection($query)
            ->addColumn('action', function ($query) {
                return view('client.events.table.donation-actions', compact('query'));
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Event  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model)
    {
        return $this->event->donations;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('eventdonations-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1);
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
                'data' => 'name',
                'title' => "Attendee's Name",
            ],
            Column::make('amount'),
            Column::make('created_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center d-flex flex-row justify-content-center align-items-center account-actions'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EventDonations_'.date('YmdHis');
    }
}
