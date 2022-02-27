<?php

namespace App\Http\Controllers;

use App\Notifications\TelegramNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;

class ToolsController extends Controller
{
    use Notifiable;

    public function routeNotificationForTelegram()
    {
        return '-513691080';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ping_google()
    {
        // $shell = shell_exec("ping google.com");
        $shell = shell_exec("ping -c 4 google.com");
        // dd($shell);
        Session::flash('message', $shell);
        return redirect()->back();
    }

    public function telegram()
    {
        $user = Auth::user();
        $user->notify(new TelegramNotification([
            'text' => "Mooove"
        ]));
        // new TelegramNotification([
        //         'text' => "Hi Welcome to the application !"
        //     ]);
        Session::flash('message', "Sent");
        return redirect()->back();
        // curl -s -X POST https://api.telegram.org/bot1924569102:AAFPrmSD_1SJfuxVstYggSqJ4oAXzC8AGDQ/sendMessage -d "chat_id=-513691080" -d "text='Test'"


    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function httpd_status()
    {
        $shell = shell_exec("systemctl status httpd");
        Session::flash('message', $shell);
        return redirect()->back();
    }

    public function tomcat8_status()
    {
        $shell = shell_exec("sudo /etc/init.d/tomcat8 status");
        Session::flash('message', $shell);
        return redirect()->back();
    }
    public function tomcat8_restart()
    {
        $shell = shell_exec("sudo /etc/init.d/tomcat8 restart");
        Session::flash('message', $shell);
        return redirect()->back();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
