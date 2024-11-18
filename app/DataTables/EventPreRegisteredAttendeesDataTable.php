<?php

namespace App\DataTables;

use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Support\Collection;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EventPreRegisteredAttendeesDataTable extends DataTable
{
    public function __construct(public Event $event, public Collection $questionTitles)
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
     * @param
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $numberOfAttendees = $this->event->plan->getFeatureValue('number_of_attendees');

        return Attendee::where('event_id', $this->event->id)
            ->hasPreRegistered()
            ->with(['answers', 'answers.question'])
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
        return $this->builder()
                    ->setTableId('eventpreregisteredattendees-table')
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
        return 'EventPreRegisteredAttendees_'.date('YmdHis');
    }
}
