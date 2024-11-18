<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventsdon:generate-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate a sitemap for eventsdon';

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
        $this->info('Generating Sitemap');

        SitemapGenerator::create(config('app.url'))
            ->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap Generated');

        return 0;
    }
}
