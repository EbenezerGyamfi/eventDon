<?php

namespace App\DataTables;

use App\Models\Event;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventTicketDataTable extends DataTable
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
            ->editColumn('ticketing_duration', function ($event) {
                return $event->ticketing_start_time.' - '.$event->ticketing_end_time;
            })
            ->addColumn('ussd_extension', function ($event) {
                return $event->ticketingUssdExtension->code;
            })
            ->editColumn('status', function ($event) {
                return view('client.events.table.status', compact('event'))->render();
            })
            ->addColumn('actions', function ($event) {
                return view('client.ticketing.table.actions', [
                    'query' => $event,
                ])->render();
            })
            ->rawColumns(['status', 'actions']);
        // ->addColumn('action', 'eventticket.action');
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $user = auth()->user();

        $query = match ($user->role) {
            'client_admin' => Event::with('ticketingUssdExtension')
                ->whereHas('ticketingUssdExtension')
                ->where('ticketing', true)
                ->where('user_id', $user->parent),

            'teller' => Event::with('ticketingUssdExtension')
                ->whereHas('ticketingUssdExtension')
                ->whereHas('tellers', fn ($query) => $query->where('user_id', $user->id))
                ->where('ticketing', true),

            default => $user->events()->with('ticketingUssdExtension')
                ->whereHas('ticketingUssdExtension')
                ->where('ticketing', true),
        };

        return $query->orderBy('ticketing_end_time', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('eventticket-table')
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
            Column::make('name')
                ->orderable(false)
                ->searchable(false),
            [
                'title' => 'Ticket USSD Extension',
                'data' => 'ussd_extension',
                'searchable' => false,
            ],
            Column::make('ticketing_duration')
                ->orderable(false)
                ->searchable(false),
            Column::make('status')
                ->searchable(false)
                ->orderable(false),
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
        return 'EventTicket_'.date('YmdHis');
    }
}
