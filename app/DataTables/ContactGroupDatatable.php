<?php

namespace App\DataTables;

use App\Models\ContactGroup;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ContactGroupDatatable extends DataTable
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
            ->addColumn('action', function ($query) {
                return view('client.contact.table.actions', compact('query'))->render();
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\ContactGroup  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ContactGroup $model)
    {
        return $model
            ->withCount('contacts')
            ->where('user_id', auth()->id())
            ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('contactgroupdatatable-table')
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
            Column::make('description'),
            [
                'data' => 'contacts_count',
                'title' => 'Number of Contacts',
                'searchable' => false,
            ],
            Column::make('created_at'),
            Column::computed('action')
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
        return 'ContactGroup_'.date('YmdHis');
    }
}
