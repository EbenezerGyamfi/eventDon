<?php

namespace App\Http\Controllers\Donations\Client;

use App\DataTables\DonationsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DonationsDataTable $dataTable)
    {
        $events = $this->getEvents();
        $totalDonations = Donation::whereHas('event', function ($query) {
            $user = auth()->user();

            if ($user->isTeller) {
                return $query->whereHas(
                    'tellers',
                     fn ($query) => $query->where('users.id', $user->id)
                );
            }

            return $query->where('user_id', $user->id);
        })
            ->sum('amount');

        $statistics = [
            'total_donations' => $totalDonations,
            'total_events' => $events->count(),
            'total_upcoming_events' => $this->getEvents()->upcoming()->count(),
            'total_ongoing_events' => $this->getEvents()->ongoing()->count(),
        ];

        return $dataTable->render('client.donation.index', compact('statistics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.donation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('client.donation.ShowDonation');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Account  $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Donation $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Donation  $donation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Donation $donation)
    {
        //
    }

    private function getEvents()
    {
        $user = auth()->user();

        if ($user->role == 'client') {
            return $user->events();
        } else {
            return $user->assignedEvents();
        }
    }
}
