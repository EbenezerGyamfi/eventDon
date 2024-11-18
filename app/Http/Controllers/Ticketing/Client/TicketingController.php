<?php

namespace App\Http\Controllers\Ticketing\Client;

use App\DataTables\EventTicketDataTable;
use App\DataTables\EventTicketSalesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TicketingController extends Controller
{
    public function __construct()
    {
        if (app()->environment('production')) {
            $this->middleware('signed')->only('scanQRCode');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(EventTicketDataTable $dataTable)
    {
        $user = auth()->user();
        $events = match ($user->role) {
            'client_admin' => Event::with('ticketingUssdExtension')
                ->whereHas('ticketingUssdExtension')
                ->where('ticketing', true)
                ->where('user_id', $user->parent),

            'teller' => Event::with('ticketingUssdExtension')
                ->whereHas('ticketingUssdExtension')
                ->whereHas('tellers', fn ($query) => $query->where('user_id', $user->id))
                ->where('ticketing', true),

            default => $user->events()->with('ticketingUssdExtension')
                ->whereHas('ticketingUssdExtension')
                ->where('ticketing', true)
        };

        $totalAmountSold = Ticket::whereIn('event_id', $events->pluck('id'))
            ->sum('amount');

        return $dataTable->render('client.ticketing.index', [
            'eventsWithTicketingEnabled' => $events->count(),
            'totalAmountSold' => $totalAmountSold,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
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
        $event = Event::with('ticketingUssdExtension')
            ->findOrFail($id);

        $this->authorize('view', $event);

        $totalSales = $event->tickets()->sum('amount');
        $numberOfAvialableTickets = $event->ticketTypes()->sum('no_of_available_tickets');
        $totalTicketsSold = $event->tickets()->count();
        $salesPercentage = ($totalTicketsSold * 100) / $numberOfAvialableTickets;
        $salesPercentage = round($salesPercentage, 2);

        $dataTable = new EventTicketSalesDataTable($event);

        return $dataTable->render('client.ticketing.show', [
            'event' => $event,
            'totalSales' => $totalSales,
            'salesPercentage' => $salesPercentage,
        ]);
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
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Event $event)
    {
        $this->authorize('verify-ticket', $event);

        $ticket = $event->tickets()->with('ticketType')
            ->where('code', $request->code)
            ->first();

        if (is_null($ticket)) {
            return back()->with('error', 'The ticket code does not exist');
        }

        if ($ticket->status === Ticket::$USED) {
            return back()->with('error', 'The ticket code has already been used');
        }

        $ticket->update([
            'status' => Ticket::$USED,
            'verified_by' => auth()->id(),
        ]);

        $ticketDetails = 'Ticket verified successfully. Customer purchased ';
        $ticketDetails .= $ticket->no_of_tickets.' '.$ticket->ticketType->name
            .' '.Str::plural('ticket', $ticket->no_of_tickets);

        return back()->with('ticketDetails', $ticketDetails);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
    }

    public function verifyTicket(Event $event)
    {
        return view('client.ticketing.verify-ticket', compact('event'));
    }

    public function scanQRCode($id)
    {
        $ticket = Ticket::with(['event', 'ticketType'])
            ->findOrFail($id);

        return view('client.ticketing.qr-code', [
            'ticket' => $ticket,
        ]);
    }
}
