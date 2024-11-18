<?php

namespace App\DataTables\Admin;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserEventsDatatable extends DataTable
{
    public function __construct(private User $user)
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
            ->editColumn('name', function ($event) {
                return view('admin.events.table.name', [
                    'query' => $event,
                ]);
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
            ->addColumn('status', function ($event) {
                return view('client.events.table.status', compact('event'))->render();
            })
            ->rawColumns(['date', 'status', 'date']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->user
            ->events()
            ->with([
                'ussdExtension' => function ($query) {
                    $query->withTrashed()->select(['id', 'code']);
                },
            ]);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('admin-usereventsdatatable-table')
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
            Column::make('USSD_Extension')
                ->searchable(false)
                ->orderable(false),
            Column::make('date')
                ->orderable(false)
                ->searchable(false),
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
        return 'Admin_UserEvents_'.date('YmdHis');
    }
}
