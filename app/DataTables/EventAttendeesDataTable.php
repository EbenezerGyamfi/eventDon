<?php

namespace App\DataTables;

use App\Models\Attendee;
use App\Models\Event;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventAttendeesDataTable extends DataTable
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
        $table = datatables()
            ->eloquent($query);

        foreach ($this->questionTitles as $title) {
            $table = $table->editColumn($title, function ($attendee) use ($title) {
                $data = 'Not Available';
                $attendee->answers->each(function ($answer) use (&$data, $title) {
                    if (strtolower($answer->question->title) == strtolower($title)) {
                        $data = $answer->answer;
                    }
                });

                return $data;
            })
            ->filterColumn($title, function ($query, $keyword) {
                return $query->whereHas('answers', function ($query) use ($keyword) {
                    return $query->where('answer', 'like', '%'.$keyword.'%');
                });
            });
        }

        $table = $table->editColumn('phone', function ($attendee) {
            return is_null($attendee->phone) ? 'Not Available' : $attendee->phone;
        });

        return $table->skipPaging();
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Models\Event  $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $numberOfAttendees = $this->event->plan->getFeatureValue('number_of_attendees');

        return Attendee::where('event_id', $this->event->id)
            ->isPresent()
            ->with(['answers', 'answers.question'])
            ->withCount('answers')
            ->orderBy('created_at')
            ->take($numberOfAttendees);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $columns = $this->getColumns();

        return $this->builder()
            ->setTableId('eventattendeesdatatable-table')
            ->columns($columns)
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
        $columns = $this->questionTitles->map(function ($title) {
            return [
                'title' => $title,
                'data' => $title,
                'orderable' => false,
            ];
        })
            ->toArray();
        $columns = array_merge($columns, [
            [
                'title' => 'Phone Number',
                'data' => 'phone',
            ],
            Column::make('created_at')
            ->searchable(false),
        ]);

        return $columns;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'EventAttendees_'.date('YmdHis');
    }
}
