<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Mail;

class last_transaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last_transaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check last_transaction Daytime';

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
        $last_trans_secs = 10;
        $successful_secs = 15;
         last_transaction($last_trans_secs,$successful_secs); //During day time check every 10mins  
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
}
