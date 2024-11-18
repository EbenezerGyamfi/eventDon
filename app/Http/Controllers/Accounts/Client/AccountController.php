<?php

namespace App\Http\Controllers\Accounts\Client;

use App\DataTables\AccountDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounts\StoreAccountRequest;
use App\Models\Account;
use App\Support\Phone\PhoneService;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AccountDataTable $dataTable)
    {
        return $dataTable->render('client.account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return Inertia::render(
        //     'Accounts/Client/Create'
        // );
        return view('client.account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountRequest $request)
    {
        $data = $request->only(['name', 'type']);

        if ($data['type'] != 'wallet') {
            $data['account_number'] = $request->input('account_number');
        } else {
            $data['account_number'] = Str::random(10);
        }

        switch ($data['type']) {
            case 'mobile':
                $data['account_number'] = PhoneService::formatPhoneNumber($data['account_number']);
                $data['details'] = [
                    'network' => $request->input('network'),
                ];
                break;

            case 'bank':
                $data['details'] = [
                    'bank_branch' => $request->input('bank_branch'),
                    'bank_name' => $request->input('bank_name'),
                ];
                break;

            case 'card':
                $data['details'] = [
                    'card_type' => $request->input('card_type'),
                ];
                break;
        }

        $data['user_id'] = $request->user()->id;

        Account::create($data);

        return redirect(route('accounts.index'))->with('message', 'Payment Account Created');
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
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        // return Inertia::render('Accounts/Client/Edit', [
        //     'account' => $account,
        // ]);
        return view('client.account.edit', [
            'account' => $account,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAccountRequest $request, Account $account)
    {
        $data = $request->only(['name', 'account_number']);

        switch ($account->type) {
            case 'mobile':
                $data['account_number'] = PhoneService::formatPhoneNumber($data['account_number']);
                $data['details'] = [
                    'network' => $request->input('network'),
                ];
                break;

            case 'bank':
                $data['details'] = [
                    'bank_branch' => $request->input('bank_branch'),
                    'bank_name' => $request->input('bank_name'),
                ];
                break;

            case 'card':
                $data['details'] = [
                    'card_type' => $request->input('card_type'),
                ];
                break;
        }

        $account->update($data);

        return redirect(route('accounts.index'))->with('message', 'Account Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        $account->delete();

        return back()->with('message', 'Account deleted');
    }
}
