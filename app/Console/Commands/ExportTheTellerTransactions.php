<?php

namespace App\Console\Commands;

use App\Exports\TransactionExport;
use App\Models\Transaction;
use App\Support\Payment\PaymentService;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ExportTheTellerTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:theteller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export theteller transactions to csv file';

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
        $status = $this->ask('Which transaction status would you like to export ?');

        $transactions = Transaction::where('provider', PaymentService::$PROVIDER_THETELLER);

        $transactions = match ($status) {
            'success' => $transactions->where('status', Transaction::$SUCCESS),

            'failed' => $transactions->where('status', Transaction::$FAILED),

            default => $transactions->get()
        };

        $export = new TransactionExport($transactions);
        Excel::store($export, 'transactions-'.now()->timestamp.'.xlsx');

        $this->info('Transactions exported');

        return 0;
    }
}
