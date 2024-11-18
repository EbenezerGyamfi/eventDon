<?php

namespace App\DataTables;

use App\Models\SmsCampaign;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SmsCampaignDataTable extends DataTable
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
            ->editColumn('created_at', function ($campaign) {
                return now()->parse($campaign->created_at)->toDateTimeString();
            })
            ->addColumn('action', function ($query) {
                return view('client.sms-campaigns.table.actions', compact('query'))->render();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\SmsCampaign  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SmsCampaign $model)
    {
        return $model->with('event')
                ->whereIn('event_id', auth()->user()->events()->pluck('id'));
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('smscampaign-table')
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
                'data' => 'event.name',
                'title' => 'Event',
                'orderable' => false,
                'searchable' => false,
            ],
            Column::make('sender'),
            Column::make('status'),
            [
                'data' => 'number_of_recipients',
                'title' => 'Number of Recipients',
            ],
            [
                'data' => 'total_delivered',
                'title' => 'Total Delivered Messages',
            ],
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
        return 'SmsCampaign_'.date('YmdHis');
    }
}
