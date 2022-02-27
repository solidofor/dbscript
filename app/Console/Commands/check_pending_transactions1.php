<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class check_pending_transactions1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_pending_transactions1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check_pending_transactions1';

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
            check_pending_transactions(); //During day time check every 10mins  
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
}
