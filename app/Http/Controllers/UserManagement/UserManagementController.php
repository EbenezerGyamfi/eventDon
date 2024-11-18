<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Notifications\SendMessage;
use App\Rules\IsPhoneNumber;
use App\Support\Phone\PhoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $created_users = User::where('parent', auth()->user()->id)->get();

        return view('client.userManagement.index', ['users' => $created_users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.userManagement.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $requestBody = $request->validated();
        $random = str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890!$%^&!$%^&');
        $password = substr($random, 0, 10);

        $requestBody['password'] = Hash::make($password);
        $requestBody['phone'] = PhoneService::formatPhoneNumber($requestBody['phone']);
        $requestBody['phone_number_verified'] = '1';

        $user = User::create($requestBody);

        $this->sendPassword($password, $user);

        $user->sendEmailVerificationNotification();

        return redirect()->route('user-management.index');
    }

    public function sendPassword($password, $user)
    {
        $parent = auth()->user();

        $message =
        "Hello $user->name, $parent->name added you as a user on EventsDon. Login with the details below. \n\n URL: https://eventsdon.com \n Email: $user->email \n Password: $password";

        $user->notify(new SendMessage([
            'message' => $message,
            'sender' => config('app.sender'),
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    public function availableTellers(Request $request)
    {
        $request->validate([
            'term' => ['nullable', 'string'],
        ]);

        $searchTerm = $request->query('term');

        $user = auth()->user();
        $availableTellers = $user->tellers()
        ->whereDoesntHave('assignedEvents', function ($query) {
            return $query->ongoing();
        })
        ->where('name', 'like', '%'.$searchTerm.'%')
        ->paginate(12);

        return $availableTellers;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'phone' => ['required', new IsPhoneNumber],
            'name' => 'required',
            'email' => 'sometimes|nullable|email',
            'role' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::find($id)->update([
            'phone' => $request->input('phone'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => $request->input('role'),
        ]);

        return redirect()->back()->with('success', 'User update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'user deleted');
    }
}
