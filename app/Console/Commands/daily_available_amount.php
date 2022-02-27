<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class daily_available_amount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily_available_amount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily_available_amount';

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
        return 0;
    }
}
