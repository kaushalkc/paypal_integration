<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaypalController;
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
    return view('welcome');
});

route::get('createPaypal',[PaypalController::class,'createPaypal'])->name('createPaypal');

route::post('processPaypal',[PaypalController::class,'processPaypal'])->name('processPaypal');

route::get('processSuccess',[PaypalController::class,'processSuccess'])->name('processSuccess');

route::get('processCancel',[PaypalController::class,'processCancel'])->name('processCancel');
