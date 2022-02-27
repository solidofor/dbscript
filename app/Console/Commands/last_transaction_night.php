<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class last_transaction_night extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last_transaction_night';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check last_transaction Night time';

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
            $last_trans_secs = 30;
            $successful_secs = 45;
             last_transaction($last_trans_secs,$successful_secs); //During night time check every 30mins  
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
}
