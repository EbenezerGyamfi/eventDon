<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $route = in_array(auth()->user()->role, [
            'client', 'teller', 'client_admin',
        ]) ? route('events.index') : route('admin.home');

        return $request->wantsJson()
            ? response()->json('', 201)
            : redirect()->intended($route);
    }
}
