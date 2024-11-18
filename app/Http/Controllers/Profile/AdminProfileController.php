<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = Auth::user();

        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $user->name = $request->name;

        $status = [];
        if ($request->email && ($user->email != $request->email)) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->sendEmailVerificationNotification();
            $status['email'] = 'Please check your email for the verification link';
        }

        if ($request->phone) {
            $phoneUtil = PhoneNumberUtil::getInstance();
            $number = $phoneUtil->parse($request->phone, 'GH');
            $number = $phoneUtil->format($number, PhoneNumberFormat::E164);

            if ($user->phone != $number) {
                $user->phone = $number;
                $user->phone_number_verified = '0';
                $status['phone'] = true;
            }
        }

        $user->save();

        return Inertia::render('Profile/AdminShow', ['user' => fn () => ([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'status' => $status,
        ])]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
        /*
        ->with([
            'message' => __('general.logout_successful')
        ]);
        */
    }
}
