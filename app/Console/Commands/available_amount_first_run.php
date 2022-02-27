<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class available_amount_first_run extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'available_amount_first_run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'available_amount_first_run';

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
            log_and_dump('info','here');
        } catch (\Throwable $th) {
            log_and_dump('error',$th);
            throw $th;
        }
    }
}
