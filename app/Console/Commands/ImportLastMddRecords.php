<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Jobs\ImportLastMddRecordsJob;

class ImportLastMddRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:last:mdd:records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import last records from mddd api';

    /**
     * Execute the console command.
     */
    public function handle() {
        dispatch(new ImportLastMddRecordsJob());
    }
}
