<?php

use App\Http\Controllers\TelegramWebhookController;
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

Route::get('/', function () {
    return view('layouts.coming-soon')
        ->with([
            'openDay' =>  \Illuminate\Support\Carbon::parse('2021-12-01'),
            'now' => now(),
        ]);
});

Route::post( '/' . config('telegram.bots.mybot.token') . '/telegram-webhook', TelegramWebhookController::class)
    ->name('telegram-webhook');
