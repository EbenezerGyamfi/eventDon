<?php

namespace App\DataTables;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventTicketSalesDataTable extends DataTable
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
            ->addColumn('ticket_type', function ($ticket) {
                return $ticket->ticketType->name;
            })
            ->addColumn('verified_at', function ($ticket) {
                return $ticket->status == Ticket::$USED
                    ? $ticket->updated_at
                    : 'Not Available';
            })
            ->editColumn('status', function ($ticket) {
                return view('client.ticketing.table.status', compact('ticket'));
            })->editColumn('verified_by', function ($ticket) {
                return $ticket->verifiedBy->name ?? 'Not Avialable';
            })
            ->rawColumns(['status']);
    }

    /**
     * Get query source of dataTable
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(): Builder
    {
        return Ticket::with(['ticketType', 'verifiedBy'])
            ->where('event_id', $this->event->id)
            ->orderBy('created_at');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('eventticketsales-table')
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
                'title' => "Buyer's contact",
                'data' => 'buyer_contact',
            ],
            Column::make('status'),
            Column::make('no_of_tickets'),
            Column::make('ticket_type'),
            [
                'title' => 'Purchased At',
                'data' => 'created_at',
            ],
            Column::make('verified_at')
                ->searchable(false),
            Column::make('verified_by'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EventTicketSales_'.date('YmdHis');
    }
}
