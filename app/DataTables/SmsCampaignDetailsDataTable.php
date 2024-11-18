<?php

namespace App\DataTables;

use App\Models\SmsCampaign;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SmsCampaignDetailsDataTable extends DataTable
{
    public function __construct(private SmsCampaign $campaign)
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
            ->collection($query)
            ->addColumn('action', 'smscampaigndetails.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\SmsCampaign  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SmsCampaign $model)
    {
        return $this->campaign->smsHistories;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('smscampaigndetails-table')
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
                'data' => 'phone',
                'title' => 'Phone number',
            ],
            Column::make('message'),
            Column::make('status'),
            // Column::make('updated_at'),
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SmsCampaignDetails_'.date('YmdHis');
    }
}
