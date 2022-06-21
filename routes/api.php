 <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Joy2362\UserReport\Http\Controllers\NovaReportController;


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

 Route::get('/',reportController::class . '@index');

 Route::get('/report',reportController::class . '@report');
 Route::get('/report/{id}/view',reportController::class . '@view');

 Route::get('/report/{id}/delete',reportController::class . '@destroy');
 Route::post('/delete/multiple',reportController::class . '@destroyAll');

 Route::post('/status/change',reportController::class . '@ChangeStatus');

 Route::post('/email/send',reportController::class . '@emailSend');
