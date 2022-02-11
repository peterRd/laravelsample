<?php

use App\Models\Reading;
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
    return view('auth.login');
});
Auth::routes();
Route::post('/login', 'CustomAuthController@login');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/instruments', [\App\Http\Controllers\InstrumentController::class, 'instruments'])->name('getinstruments');
Route::post('/reading/{readingid}', [\App\Http\Controllers\ReadingController::class, 'update'])->name('updatereading');
Route::get('/readings/{instrumentid}', [\App\Http\Controllers\ReadingController::class, 'readings'])->name('readings');
