<?php

namespace App\DataTables;

use App\Models\Event;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventDataTable extends DataTable
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
            ->editColumn('USSD Extension', function (Event $event) {
                return $event->ussdExtension?->code;
            })
            ->editColumn('date', function (Event $event) {
                if ($event->start_time->toDateString() === $event->end_time->toDateString()) {
                    return $event->start_time->toDateString().'<br>'.$event->start_time->toTimeString().' - '.$event->end_time->toTimeString();
                } else {
                    return $event->start_time->toDateString().' - '.$event->end_time->toDateString().'<br>'.$event->start_time->toTimeString().' - '.$event->end_time->toTimeString();
                }
            })
            ->addColumn('status', function (Event $event) {
                return view('client.events.table.status', compact('event'))->render();
            })
            ->addColumn('actions', function ($query) {
                return view('client.events.table.actions', compact('query'))->render();
            })
            ->rawColumns(['status', 'actions', 'date']);
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
            return $model->with(['user:id,name', 'ussdExtension:id,code', 'plan'])
                ->whereHas('tellers', fn ($query) => $query->where('user_id', $user->id))
                ->latest('end_time');
        }

        return $model->with(['user:id,name', 'ussdExtension:id,code', 'plan'])
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
            ->setTableId('eventdatatable-table')
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
            Column::make('venue'),
            Column::make('USSD Extension')
                ->searchable(false)
                ->orderable(false),
            Column::make('date')
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
        return 'Event_'.date('YmdHis');
    }
}
