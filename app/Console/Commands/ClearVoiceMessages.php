<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearVoiceMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voice-messages:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear voice messages stored during uploads!';

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
        collect(Storage::disk('public')->files('voice-messages'))
            ->filter(function (string $file) {
                preg_match_all('!\d+!', $file, $matches);
                [[$timestamp]] = $matches;

                return Carbon::createFromTimestamp($timestamp)->diffInMonths() >= 1;
            })
            ->each(fn (string $file) => Storage::disk('public')->delete($file));

        return 0;
    }
}
