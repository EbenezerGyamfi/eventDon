<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        abort_if(
            ! in_array(auth()->user()->role, explode('|', $roles)),
            404,
            'You are not authorized to view this page.'
        );

        return $next($request);
    }
}
