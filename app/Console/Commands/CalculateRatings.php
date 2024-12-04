<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\CalculateRatings as CalculateRatingsJob;

use Illuminate\Support\Facades\Log;

class CalculateRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:calculate-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate players ratings';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public function handle() {
        Log::info('CalculateRatings job should start.');
        dispatch(new CalculateRatingsJob());
    }
}
