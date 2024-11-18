<?php

namespace App\Console\Commands;

use App\Exports\ExportTicketSales;
use App\Models\Event;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportTicketTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export ticket sale transactions to csv file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $eventId = $this->ask('Please enter the event id');
        $event = Event::with([
            'tickets',
            'tickets.ticketType',
            'tickets.transaction',
        ])
            ->find($eventId);

        if (is_null(($event))) {
            $this->info('Event not found');
        } else {
            $export = new ExportTicketSales($event);
            Excel::store($export, 'tickets-'.$event->id.'.xlsx');
        }

        return 0;
    }
}
