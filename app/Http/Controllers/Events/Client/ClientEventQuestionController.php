<?php

namespace App\Http\Controllers\Events\Client;

use App\DataTables\EventPreRegistrationQuestionsDataTable;
use App\DataTables\EventQuestionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Event;
use App\Models\Question;
use Illuminate\Http\Request;

class ClientEventQuestionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index($id, EventQuestionsDataTable $dataTable)
    {
        $event = Event::findOrFail($id);

        $this->authorize('view', $event);

        return $dataTable->with('event', $event)
            ->render('client.events.questions', [
                'event' => $event,
                'page_title' => 'Event - '.$event->name,
            ]);
    }

    public function showPreRegistrationQuestions($id, EventPreRegistrationQuestionsDataTable $dataTable)
    {
        $event = Event::findOrFail($id);

        $this->authorize('view', $event);

        if (! $event->ask_pre_registration_questions) {
            abort(404);
        }

        return $dataTable
            ->with('event', $event)
            ->render('client.events.pre-registration-questions', [
                'event' => $event,
                'page_title' => 'Event - '.$event->name,
            ]);
    }

    public function update(UpdateQuestionRequest $request, Event $event, Question $question)
    {
        $this->authorize('update', $event);

        if (! $question->event()->is($event)) {
            return back()->withErrors(['error' => 'Invalid operation. Please refresh and try again']);
        }

        if (strtolower($question->title) == 'name') {
            $question->update($request->only('question'));
        } else {
            $question->update($request->validated());
        }

        return back()->with('message', 'Question Updated');
    }

    public function destroy($event_id, Question $question)
    {
        $this->authorize('update', Event::find($event_id));

        if ($question->event_id != $event_id) {
            return back()
                ->withErrors(['error' => 'Invalid Operation. Please refresh your browser and try again']);
        }

        if (strtolower($question->title) == 'name') {
            return back()
                ->withErrors(['error' => 'The "Name" question can not be deleted']);
        }

        if ($question->answers()->count()) {
            return back()
                ->withErrors(['error' => 'Questions that have been answered can not be deleted']);
        }

        $question->delete();

        return back()->with('message', 'The question has been successfully deleted');
    }
}
