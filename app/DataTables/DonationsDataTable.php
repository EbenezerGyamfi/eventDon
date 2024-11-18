<?php

namespace App\DataTables;

use App\Models\Event;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DonationsDataTable extends DataTable
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
            ->addColumn('donations', function (Event $event) {
                return '₵'.$event->donations->sum('amount');
            })
            ->addColumn('donators', function (Event $event) {
                return $event->donations_count;
            })
            ->addColumn('status', function (Event $event) {
                return view('client.events.table.status', compact('event'))->render();
            })
            ->addColumn('action', function ($query) {
                return view('client.donation.table.actions', compact('query'))->render();
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Event  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model)
    {
        $user = auth()->user();

        if ($user->isTeller) {
            return $model->with('donations')
                    ->withCount('donations')
            ->whereHas('tellers', fn ($query) => $query->where('users.id', $user->id))
            ->latest('end_time');
        }

        return $model->with('donations')
                ->withCount('donations')
            ->where('user_id', $user->id)
            ->latest('end_time');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('donations-table')
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
                'data' => 'name',
                'title' => 'Event Name',
            ],
            Column::make('donations')
                ->orderable(false)
                ->searchable(false),
            Column::make('donators')
                ->orderable(false)
                ->searchable(false),
            Column::make('status')
                ->orderable(false)
                ->searchable(false),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Donations_'.date('YmdHis');
    }
}
