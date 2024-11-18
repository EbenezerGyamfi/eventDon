<?php

namespace App\Http\Controllers\Gifts\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gifts\StoreGiftRequest;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\Gifts;
use App\Notifications\SendMessage;
use App\Support\Gifts\GiftsService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class GiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $user = auth()->user();
        $events = match ($user->role) {
            'client_admin' => Event::with(['gifts'])->where('user_id', $user->parent)->get(),
            'teller' => Event::with(['gifts'])->whereHas('tellers', fn ($query) => $query->where('user_id', $user->id))->get(),

            default => $user->events()->with('gifts')->get()
        };

        $data['page_title'] = 'All Events with Gifts for '.auth()->user()->name;

        return view('client.gifts.list', compact('data', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Event $event)
    {
        if ($event->expected_attendees <= 30) {
            return back()->with('error', 'Sorry! Gifts can only be received for paid events');
        }

        $event->load('gifts');
        $gifts = $event->gifts;
        $data['page_title'] = 'Receive Gifts for "'.$event->name.'"';

        return view('client.gifts.create', compact('data', 'event', 'gifts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws Exception
     */
    public function store(StoreGiftRequest $request)
    {
        $attributes = $request->validated();
        try {
            $giftCode = GiftsService::generateGiftCode();
        } catch (Exception $e) {
            return back()->with('error', 'Unable to generate Gift Code. Please try again or contact your System Administrator');
        }
        $attributes['code'] = $giftCode;
        $attributes['received_by'] = auth()->user()->id;
        $donor = Attendee::where(['id' => $attributes['attendee_id']])->first();
        $donorName = ! empty($donor->getName()) ? $donor->getName() : 'friend';

        if (Gifts::create($attributes)) {
            $donor->notify(new SendMessage([
                'message' => "Dear $donorName, your gift with code $giftCode has successfully been recorded. Thank you for your support",
                'sender' => config('app.sender'),
            ]));

            return back()->with('message', 'Successfully received gift');
        }

        return back()->with('error', 'Failed while processing gift. Please try again or contact your System Administrator');
    }

    /**
     * Display the specified resource.
     *
     * @param  Gifts  $gifts
     * @return \Illuminate\Http\Response
     */
    public function show(Gifts $gifts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gifts  $gifts
     * @return Application|Factory|View
     */
    public function edit(Gifts $gift)
    {
        $event = $gift->event;

        if ($event->expected_attendees <= 30) {
            return back()->with('error', 'Sorry! Gifts can only be updated for paid events');
        }

        $data['page_title'] = 'Receive Gifts for "'.$event->name.'"';

        return view('client.gifts.update', compact('data', 'event', 'gift'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gifts  $gifts
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws Exception
     */
    public function update(StoreGiftRequest $request, Gifts $gift)
    {
        $attributes = $request->validated();

        try {
            $giftCode = ! empty($gift->code) ? $gift->code : GiftsService::generateGiftCode();
        } catch (Exception $e) {
            return back()->with('error', 'Unable to generate Gift Code. Please try again or contact your System Administrator');
        }

        if ($attributes['type'] === 'wrapped parcel') {
            $attributes['name'] = '';
        }

        $attributes['code'] = $giftCode;
        $attributes['received_by'] = auth()->user()->id;
        $attributes['updated_by'] = auth()->user()->id;

        $oldDonor = $gift->donor;
        $newDonor = Attendee::where(['id' => $attributes['attendee_id']])->first();

        if (Gifts::where(['id' => $gift->id])->update($attributes)) {
            if ($oldDonor->id == $newDonor->id) {
                $donorName = ! empty($oldDonor->getName()) ? $oldDonor->getName() : 'friend';
                $oldDonor->notify(new SendMessage([
                    'message' => "Dear $donorName, your gift with code $giftCode has successfully been updated. If you did not request this update, kindly contact the event organizers to verify. Thank you",
                    'sender' => config('app.sender'),
                ]));
            } else {
                $oldDonorName = ! empty($oldDonor->getName()) ? $oldDonor->getName() : 'friend';
                $oldDonor->notify(new SendMessage([
                    'message' => "Dear $oldDonorName, your gift with code $giftCode has been updated for another donor. This means you are no longer the donor to this gift. If you did not request this update, kindly contact the event organizers to verify. Thank you",
                    'sender' => config('app.sender'),
                ]));

                $newDonorName = ! empty($newDonor->getName()) ? $newDonor->getName() : 'friend';
                $newDonor->notify(new SendMessage([
                    'message' => "Dear $newDonorName, a gift with code $giftCode has been attributed to you. This means you are now the donor to this gift. If you did not request this update or have not made any donations, kindly contact the event organizers to verify. Thank you",
                    'sender' => config('app.sender'),
                ]));
            }

            return redirect(route('gifts.create', $gift->event))->with('message', 'Successfully updated gift');
        }

        return back()->with('error', 'Failed while updating gift. Please try again or contact your System Administrator');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gifts  $gifts
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Gifts $gift)
    {
        if ($gift->delete()) {
            return back()->with('message', 'Successfully deleted Gift');
        }

        return back()->with('error', 'Failed to delete Gift. Please try again');
    }

    public function listEventGifts(Event $event)
    {
        $data['page_title'] = 'All Gifts you have received for "'.$event->name.'"';
        $event->load('gifts');
        $gifts = $event->gifts;

        return view('client.gifts.list-gifts', compact('data', 'gifts', 'event'));
    }
}
