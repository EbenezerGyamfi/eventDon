<?php

use App\Http\Controllers\Api\HandleUssdTicketing;
use App\Http\Controllers\UssdSessions\HandleUssdSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('handle-ussd-session', HandleUssdSession::class)->name('handle-ussd-session');

Route::post('handle-ussd-ticketing', HandleUssdTicketing::class)->name('handle-ussd-ticketing');
