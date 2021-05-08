<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
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

Route::get('/', function() {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/addCard', function() {
    return view('addCard');
})->middleware('auth');

Route::post('/dodajIskaznicu', [CardController::class, 'dodajIskaznicu']);

Route::get('/viewProfile/{brIskaznice}', [CardController::class, 'dohvatiProfil'])->where('brIskaznice', '[0-9]+')->name('viewProfile');
