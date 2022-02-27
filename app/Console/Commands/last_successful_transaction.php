<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Mail;
class last_successful_transaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'last_successful_transaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check the last successful transaction';

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
            // last_successful_transaction(15); //During day time check every 15mins 
        } catch (\Throwable $th) {
            Log::error($th);
            throw $th;
        }
    }
}
