<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;

class CanManageEvent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $event = is_string($request->route('event'))
                ? Event::findOrFail($request->route('event'))
                : $request->route('event');

        if (! $event->user()->is(auth()->user())) {
            abort(403, 'You do not have the appropriate permissions');
        }

        return $next($request);
    }
}
