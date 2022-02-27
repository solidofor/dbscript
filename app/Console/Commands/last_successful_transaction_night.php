<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class last_successful_transaction_night extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last_successful_transaction_night';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the last successful transaction Night time';

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
            // last_successful_transaction(45); //During night time check every 45mins 
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
}
