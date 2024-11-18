<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;

class CanManageAccount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $account = is_string($request->route('account'))
                ? Account::findOrFail($request->route('account'))
                : $request->route('account');

        if (! $account->user()->is(auth()->user())) {
            abort(403, 'You do not have the appropriate permissions');
        }

        return $next($request);
    }
}
