<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
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
            log_and_dump('info','+++++++++++++++ Starting FIRST RUN available_amount ++++++++++++++');
            $time_start = microtime(true);
            $currentTime = Carbon::now();
            //user
            $users = DB::connection('mysql2')->table('users_profile')->inRandomOrder()->get();
            log_and_dump('info','Users Count '.$users->count());
            foreach ($users as $user) {
                log_and_dump('info','Processing '.$user->name ." ($user->trxnkey)");
                $possible_fees = DB::connection('mysql2')->table('fee_customer')->where('client_id',$user->trxnkey)->first();
                $fees = !empty($possible_fees)? $possible_fees->new_fee :1.7;
                log_and_dump('info', 'User '.$user->name ." Fees ($fees)");
                    
                //check if user already has records from the previous
                @$available_amount = DB::connection('mysql2')->table('available_amounts')
                        ->where('clientid',$user->trxnkey)
                        ->where('date',Carbon::now()->subDay()->format('Y-m-d'))
                        ->first();
                if($available_amount){
                    log_and_dump('notice',$user->name." has been sorted skipping to the next");
                    log_and_dump('info',"//_______//_______//________//________//");
                    usleep(1000000);//1 sec
                    continue;
                }
                // $transactions = DB::connection('mysql2')->table('transactions')
                //     ->where('clientid',$user->trxnkey)
                //     ->where('response', '00')
                //     ->orWhere('response', '0')
                //     ->inRandomOrder()->get();
                
                    $transactions = DB::connection('mysql2')->table('transactions')
                        ->where('clientid',$user->trxnkey)
                        ->whereBetween('trxndate', [Carbon::now()->startOfDay()->subYears(10), Carbon::now()->endOfDay()->subDay(1)])
                        ->where(function ($query) {
                        $query->where('response', '=', '00')
                              ->orWhere('response', '=', '0');
                    })->inRandomOrder()->get();
                    // ->toSql();dd($transactions);


                log_and_dump('info',"Transactions Found for $user->name  Count ".$transactions->count());

                $merchant_amount =0;
                $fee_amount =0;
                $total_amount =0;
                foreach ($transactions as $transaction) {
                    // log_and_dump('info','Processing '.$user->name ." ($transaction->clientrefno)");
                    $total_amount = $total_amount + $transaction->amount ;
                }
                $fee_amount = ceil($total_amount *  ($fees/100));
                $merchant_amount = $total_amount - $fee_amount;
                log_and_dump('info',$user->name ." Total Amount is $total_amount");
                log_and_dump('info',$user->name ." Fee Amount is $fee_amount");
                log_and_dump('info',$user->name ." Merchant Amount is $merchant_amount");
                // Add record
                $saved_details = DB::connection('mysql2')->table('available_amounts')->insert(
                    [
                        'clientid' => $user->trxnkey, 
                        'merchant_amount' => $merchant_amount,
                        'fee_amount' => $fee_amount,
                        'total_amount' => $total_amount,
                        'date' =>  Carbon::now()->subDay()->format('Y-m-d')//Carbon::now()->toDateTimeString()
                    ]
                );
                log_and_dump('notice',$user->name." details saved moving to next");
                log_and_dump('info',"_________________________________");
                usleep(3000000);//3 sec
                // dd('---Release when ready---');
            }
            log_and_dump('info',"Query took " . number_format(microtime(true) - $time_start, 2) . " seconds. to complete");
            log_and_dump('info','+++++++++++++++ Ending FIRST RUN available_amount ++++++++++++++');

            //last
        } catch (\Throwable $th) {
            log_and_dump('error',$th);
            throw $th;
        }
    }
}
