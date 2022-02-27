<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['register' => false]);
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
  ]);
Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/ping_google', [App\Http\Controllers\ToolsController::class, 'ping_google'])->name('ping_google');

Route::get('/httpd_status', [App\Http\Controllers\ToolsController::class, 'httpd_status'])->name('httpd_status');
Route::get('/tomcat8_status', [App\Http\Controllers\ToolsController::class, 'tomcat8_status'])->name('tomcat8_status');
Route::get('/tomcat8_restart', [App\Http\Controllers\ToolsController::class, 'tomcat8_restart'])->name('tomcat8_restart');


Route::get('/telegram', [App\Http\Controllers\ToolsController::class, 'telegram'])->name('telegram');
