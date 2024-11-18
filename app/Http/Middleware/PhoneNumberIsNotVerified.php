<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PhoneNumberIsNotVerified
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
        $user = $request->user();

        if ($user->phone_number_verified) {
            return redirect()->to(route('home'));
        }

        return $next($request);
    }
}
