<?php

use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

use App\Http\Controllers\CurrencyController;

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

Route::get('/', [CurrencyController::class, 'index'])->name('home');

Route::get('/currencies/rates/{curr_code}', [CurrencyController::class, 'show'])->name('showCurrency');
Route::post('/currencies/rates/{curr_code}', [CurrencyController::class, 'show'])->name('showRateDate');

Route::get('/download_csv/{curr_code}/{date}', [CurrencyController::class, 'download_csv'])->name('download_csv');
