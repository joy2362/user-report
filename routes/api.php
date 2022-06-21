<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Joy2362\UserReport\Http\Controllers\UserReportController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

 Route::get('/',UserReportController::class . '@index');

 Route::get('/report',UserReportController::class . '@report');
 Route::get('/report/{id}/view',UserReportController::class . '@view');

 Route::get('/report/{id}/delete',UserReportController::class . '@destroy');
 Route::post('/delete/multiple',UserReportController::class . '@destroyAll');

 Route::post('/status/change',UserReportController::class . '@ChangeStatus');

 Route::post('/email/send',UserReportController::class . '@emailSend');
