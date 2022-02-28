<?php

use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Mail;
ini_set('max_execution_time', '0'); //Infinity

function log_and_dump($status,$value) {
    if($status == "info") {
        Log::info($value);
    }elseif ($status == "emergency"){
        Log::emergency($value);
    }elseif ($status == "critical"){
        Log::critical($value);
    }elseif ($status == "error"){
        Log::error($value);
    }elseif ($status == "warning"){
        Log::warning($value);
    }elseif ($status == "notice"){
        Log::notice($value);
    }elseif ($status == "debug"){
        Log::debug($value);
    }
    dump($value);
}

function last_transaction($last_trans_secs, $successful_secs)
{
    // $trns = FacadesDB::connection('mysql2')->table('transactions')
    // ->whereRaw('trxndate >= now() - interval 5 minute')->get();
    // dd($trns->count());
    $time_start = microtime(true);
    $currentTime = Carbon::now();
    //last
    $transaction = FacadesDB::connection('mysql2')->table('transactions')->latest('trxndate')->first();
    $last_trans_timeFrame = Carbon::now()->subMinutes($last_trans_secs);
    //successful
    $successful_transaction = FacadesDB::connection('mysql2')->table('transactions')
        ->where('response', '00')
        ->latest('trxndate')
        ->first();
    $successful_timeFrame = Carbon::now()->subMinutes($successful_secs);
    //
    if ($transaction->trxndate > $last_trans_timeFrame && $successful_transaction->trxndate > $successful_timeFrame) {
        $response = [
            "----------------------------Starting Transaction Scan-----------------------",
            "Execution Time          :$currentTime",
            "----------",
            "BenchMarking last transaction Time $last_trans_secs mins :$last_trans_timeFrame",
            "Last transaction Time         :$transaction->trxndate | " . Carbon::parse($transaction->trxndate)->diffForHumans(),
            "----------",
            "BenchMarking last successful transaction Time $successful_secs mins :$successful_timeFrame",
            "Last successful transaction Time         :$successful_transaction->trxndate | " . Carbon::parse($successful_transaction->trxndate)->diffForHumans(),
            "----------",
            "Query took " . number_format(microtime(true) - $time_start, 2) . " seconds. to complete",
            "Successful",
            "------------------------------Ending Transaction Scan-----------------------",
        ];
        Log::info($response);
        dd($response);
    } else {
        $response = [
            "----------------------------Starting Transaction Scan-----------------------",
            $currentTime = "Execution Time            : $currentTime",
            "----------",
            $last_trans_timeFrame = "BenchMarking last transaction Time $last_trans_secs mins :$last_trans_timeFrame",
            $transaction_date =  "Last transaction Time :$transaction->trxndate | " . Carbon::parse($transaction->trxndate)->diffForHumans(),
            "----------",
            $successful_timeFrame = "BenchMarking last successful transaction Time $successful_secs mins :$successful_timeFrame",
            $successful_transaction_date = "Last successful transaction Time :$successful_transaction->trxndate | " . Carbon::parse($successful_transaction->trxndate)->diffForHumans(),
            "----------",
            $processing_time = "Query took " . number_format(microtime(true) - $time_start, 2) . " seconds. to complete",
            "Failing",
            "------------------------------Ending Transaction Scan-----------------------",
        ];
        Log::critical($response);
        // $shell = shell_exec('curl -s -X POST https://api.telegram.org/bot1924569102:AAFPrmSD_1SJfuxVstYggSqJ4oAXzC8AGDQ/sendMessage -d "chat_id=-513691080" -d "text='.$response.'"');
        $log = "\nTroubleshooting Steps\nLogs -f /var/log/tomcat8/catalina.out";
        $stop = "Stop Tomcat /etc/init.d/tomcat8 stop";
        $start = "Start Tomcat /etc/init.d/tomcat8 start";
        $data = [
            'chat_id' => "-1001284707814",
            'text' => "Alert! Transactions are failing\n$transaction_date\n$successful_transaction_date\n$log\n$stop\n$start"
        ];
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.telegram.org/bot1924569102:AAFPrmSD_1SJfuxVstYggSqJ4oAXzC8AGDQ/sendMessage",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            //CURLOPT_VERBOSE =>1,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type:application/json'
            ),
        ));
        @$response_msg = curl_exec($curl);
        curl_close($curl);

        $data = array(
            'currentTime' => $currentTime,
            'timeFrame' => $last_trans_timeFrame,
            'transaction_date' => $transaction_date,
            'successful_timeFrame' => $successful_timeFrame,
            'successful_transaction_date' => $successful_transaction_date,
            'processing_time' => $processing_time,
        );
        //send email
        Mail::send('last_transaction_mail', $data, function ($message) {
            $message->to('gabriel@qosic.com', 'Gabriel')->subject(config('app.name'));
            $message->cc(['emma@qosic.com', 'jacques@qosic.com', 'aremou@qosic.com']);
            $message->from('noc@qosic.com', config('app.name'));
        });
        Log::notice('Email was sent successfully');
        //send SMS
        dd($response);
    }
}








// function last_successful_transaction($last_trans_secs)
// {
//     //code...
//     $time_start = microtime(true);
//     $transaction = FacadesDB::connection('mysql2')->table('transactions')
//         ->where('response', '00')
//         ->latest('trxndate')
//         ->first();
//     $last_trans_timeFrame = Carbon::now()->subMinutes($last_trans_secs);
//     $currentTime = Carbon::now();
//     if ($transaction->trxndate > $last_trans_timeFrame) {
//         $response = [
//             "----------------------------Starting Last Transaction Scan-----------------------",
//             "Execution Time          :$currentTime",
//             "BenchMarking Time $last_trans_secs mins :$last_trans_timeFrame",
//             "Last Successful Trans Time   :$transaction->trxndate | " . Carbon::parse($transaction->trxndate)->diffForHumans(),
//             "Query took " . number_format(microtime(true) - $time_start, 2) . " seconds. to complete",
//             "Successful",
//             "------------------------------Ending Last Transaction Scan-----------------------",
//         ];
//         Log::info($response);
//         dd($response);
//     } else {
//         $response = [
//             "----------------------------Starting Last Transaction Scan-----------------------",
//             $currentTime = "Execution Time            : $currentTime",
//             $last_trans_timeFrame = "BenchMarking Time $last_trans_secs mins : $last_trans_timeFrame",
//             $transaction_date =  "Last Successful Trans Time        : $transaction->trxndate | " . Carbon::parse($transaction->trxndate)->diffForHumans(),
//             $processing_time = "Query took " . number_format(microtime(true) - $time_start, 2) . " seconds. to complete",
//             "Failing",
//             $transaction,
//             "------------------------------Ending Last Transaction Scan-----------------------",
//         ];
//         Log::warning($response);
//         $data = array(
//             'currentTime' => $currentTime,
//             'timeFrame' => $last_trans_timeFrame,
//             'transaction_date' => $transaction_date,
//             'processing_time' => $processing_time,
//             'transaction' => $transaction,
//         );
//         //send email
//         Mail::send('last_successful_transaction_mail', $data, function ($message) {
//             $message->to('gabriel@qosic.com', 'Gabriel')->subject(config('app.name') . " | Transactions are Failing");
//             $message->cc(['emma@qosic.com', 'jacques@qosic.com', 'aremou@qosic.com']);
//             $message->from('noc@qosic.com', config('app.name'));
//         });
//         Log::notice('Email was sent successfully');
//         //send SMS
//         dd($response);
//     }
// }


function check_pending_transactions(){
    $time_start = microtime(true);
    $currentTime = Carbon::now();
    //last
    $transactions = FacadesDB::connection('mysql2')->table('transactions')
        ->where('response', '01')
        ->whereBetween('trxndate', [Carbon::now()->startOfHour()->subHour(1), Carbon::now()->endOfHour()->subHour(1)])
        // ->where('trxndate' > Carbon::now()->subMinutes(4)->toDateTimeString())
        ->inRandomOrder()->get();

        $transref_array = [];
    if ($transactions) {
        
        foreach ($transactions as $transaction) {
            #call the API
            $data = [
                'clientid' => $transaction->clientid,
                'transref' => $transaction->clientrefno,
            ];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://qosic.net:8443/QosicBridge/user/gettransactionstatus2",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_SSL_VERIFYHOST => FALSE,
                CURLOPT_SSL_VERIFYPEER => FALSE,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array(
                    'Content-Type:application/json',
                    'Authorization: Basic ' . base64_encode("QSUSR14:Q99R74QPTW47MVWD1Q6E2")
                ),
            ));
            @$response = curl_exec($curl);
            curl_close($curl);
            // Log::info($response);
            @$response = json_decode($response); //json proper
            // $responsemsg = "SUCCESSFUL";
            $transref_array[] = $transaction->clientrefno." -- ".@$response->responsemsg;
        }
    }
    // dd($transref);
    //foreach 

    @$count = $transactions->count();
    @$transref = implode(" | ",$transref_array);
    // dd($transref);
    $response = [
        "----------------------------Starting Pending Transaction Scan-----------------------",
        "Execution Time          :$currentTime",
        "----------",
        "Pending Transactions within the last hour ($count)",
        "Transref  :",
        $transref,
        "----------",
        "Query took " . number_format(microtime(true) - $time_start, 2) . " seconds. to complete",
        "------------------------------Ending Pending Transaction Scan-----------------------",
    ];
    Log::notice($response);
    // dd($transactions->count());
    dump($response);
}