<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PhoneNumberIsVerified
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

        if (! $user->phone_number_verified && $user->email_verified_at) {
            return $request->expectsJson()
                ? abort(403, 'Your phone number is not verified.')
                : redirect()->to(route('otp.request'));
        } elseif (! $user->phone_number_verified && ! $user->email_verified_at) {
            return $request->expectsJson()
                ? abort(403, 'Your email is not verified.')
                : redirect()->to(route('verification'));
        }

        return $next($request);
    }
}
