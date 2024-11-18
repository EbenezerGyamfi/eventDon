<?php

namespace App\Http\Controllers\Events\Client;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadProgramLineup extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Event $event)
    {
        if (is_null($event->program_lineup)) {
            return redirect()->route('events.show', $event->id);
        }

        return Storage::disk('public')->download($event->program_lineup);
    }
}
