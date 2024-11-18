<?php

namespace App\DataTables;

use App\Models\Event;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventPreRegistrationQuestionsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed  $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $table = datatables()
            ->eloquent($query);

        if (! auth()->user()->isTeller) {
            return $table->addColumn('action', function ($question) {
                return view('client.events.table.question-actions', [
                    'query' => $question,
                ]);
            });
        }

        return $table;
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Event  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model)
    {
        return $this->event->preRegistrationQuestions()->orderBy('order');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('event-pre-registration-questions-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $columns = [
            Column::make('title'),
            Column::make('question'),
        ];

        if (! auth()->user()->isTeller) {
            array_push(
                $columns,
                Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                //   ->width(60)
                  ->addClass('text-center d-flex flex-row justify-content-center align-items-center account-actions'),
            );
        }

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EventPreRegistrationQuestions_'.date('YmdHis');
    }
}
