<?php

namespace App\Console\Commands;

use App\Models\UssdExtension;
use Illuminate\Console\Command;

class AddUssdExtensionRange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ussd:add-range';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add range of ussd extensions';

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
        try {
            $start = (int) $this->ask('What is the starting range?');
            $end = (int) $this->ask('What is the ending range?');
            $excluded = $this->ask('What are the exlcuded values?');

            $excludedValues = $excluded ? explode(',', $excluded) : [];

            $bar = $this->output->createProgressBar($end - $start);

            $bar->start();

            foreach (range($start, $end) as $value) {
                if (! in_array($value, $excludedValues)) {
                    UssdExtension::create([
                        'code' => "*928*{$value}#",
                    ]);
                }
                $bar->advance();
            }

            $bar->finish();

            $this->newLine(3);
            $this->info("USSD extension range block *928*{$start}# to *928*{$end}# added successfully");
        } catch (\Exception $e) {
            $this->newLine(3);
            $this->error($e->getMessage());
        }

        return 0;
    }
}
