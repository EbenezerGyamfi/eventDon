<?php

namespace App\Http\Controllers\Donations\Client;

use App\Http\Controllers\Controller;
use App\Models\Event;

class DonationTransactionsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $events = match ($user->role) {
            'client_admin' => Event::with(['donationTransactions'])->where('user_id', $user->parent)->get(),
            'teller' => Event::with(['donationTransactions'])->whereHas('tellers', fn ($query) => $query->where('user_id', $user->id))->get(),

            default => $user->events()->with('gifts')->get()
        };

        $page_title = 'Donation Transactions';

        return view('client.donation.transactions.index', compact('events', 'page_title'));
    }

    public function show(Event $event)
    {
        $page_title = 'Donation Transactions for '.$event->name;
        $transactions = $event->donationTransactions;

        return view('client.donation.transactions.show', compact('transactions', 'page_title'));
    }
}
