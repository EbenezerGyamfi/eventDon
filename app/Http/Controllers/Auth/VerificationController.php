<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyOtpRequest;
use App\Notifications\SendOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    public function index()
    {
        return view('client.Auth.otpRequest');
    }

    public function send(Request $request)
    {
        $user = $request->user();

        $user->notify(new SendOtp);

        return response()->json(['sent' => true]);
    }

    public function verify(VerifyOtpRequest $request)
    {
        $user = $request->user();

        $user->phone_number_verified = '1';

        $user->save();

        $user->accounts()->create([
            'name' => $user->name,
            'account_number' => Str::random(10),
            'type' => 'wallet',
        ]);

        $user->wallets()->create([
            'balance' => 0,
            'currency' => 'GHS',
        ]);

        $route = in_array(auth()->user()->role, [
            'client', 'teller', 'client_admin',
        ]) ? route('events.index') : route('admin.home');

        return redirect(($route));
    }
}
