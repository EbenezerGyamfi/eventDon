<?php

namespace App\DataTables\Admin;

use App\Models\Event;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EventTicketsDataTable extends DataTable
{

    public function __construct(private Event $event)
    {
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
     
         ->editColumn('buyer_contact', function ($event) {
            return $event->buyer_contact;
        })
        ->editColumn('no_of_tickets',function($event){
            return $event->no_of_tickets;
        })
        ->editColumn('Time Bought',function($event){
            return $event->created_at;
        })
        ->editColumn('status', function($event){
            return view('client.events.table.ticket-status', compact('event'))->render();
        })
        
        ->rawColumns(['date', 'status', 'date']);

        
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\EventTicket $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {

         return $this->event->tickets();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('eventtickets-table')
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
            Column::make('buyer_contact')
            ->searchable(false)
            ->orderable(false),
            Column::make('no_of_tickets')
            ->searchable(false)
            ->orderable(false),
            Column::make('Time Bought')
            ->searchable(false)
            ->orderable(false),
            Column::make('status')
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
        return 'EventTickets_' . date('YmdHis');
    }
}
