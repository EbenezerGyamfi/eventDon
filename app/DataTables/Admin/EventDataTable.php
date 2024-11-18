<?php

namespace App\DataTables\Admin;

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
            ->editColumn('name', function ($event) {
                return view('admin.events.table.name', [
                    'query' => $event,
                ]);
            })
            ->editColumn('organizer', function ($event) {
                return $event->user->name;
            })
            ->filterColumn('organizer', function ($query, $keyword) {
                return $query->whereHas('user', function ($query) use ($keyword) {
                    return $query->where('name', 'like', '%'.$keyword.'%');
                });
            })
            ->editColumn('USSD_Extension', function ($event) {
                return $event->ussdExtension?->code;
            })
            ->editColumn('date', function ($event) {
                if ($event->start_time->toDateString() === $event->end_time->toDateString()) {
                    return $event->start_time->toDateString().'<br>'.$event->start_time->toTimeString().' - '.$event->end_time->toTimeString();
                } else {
                    return $event->start_time->toDateString().' - '.$event->end_time->toDateString().'<br>'.$event->start_time->toTimeString().' - '.$event->end_time->toTimeString();
                }
            })
            ->editColumn('donations', function ($event) {
                return view('admin.events.table.donation', [
                    'query' => $event,
                    'amount' => number_format($event->donations->sum('amount'),2),
                ]);
            })
           

            ->editColumn('amount', function ($event) {

                return view('admin.events.table.amount', [
                    'query' => $event,
                    'amount' => $event->tickets->sum('amount')
                ]);
            })
            ->addColumn('status', function ($event) {
                return view('client.events.table.status', compact('event'))->render();
            })
            ->rawColumns(['date', 'status', 'date']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Event  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model)
    {
        return $model->with([
            'user:id,name',
            'ussdExtension' => function ($query) {
                $query->withTrashed()->select(['id', 'code']);
            },
        ])
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
            ->setTableId('admin-event-table')
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
            Column::make('organizer')
            ->orderable(false),
            Column::make('USSD_Extension')
            ->searchable(false)
            ->orderable(false),
            Column::make('date')
                ->orderable(false)
                ->searchable(false),
            Column::make('donations')
            ->searchable(false)
            ->orderable(false),
            Column::make('amount')
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
        return 'Admin_Event_'.date('YmdHis');
    }
}
