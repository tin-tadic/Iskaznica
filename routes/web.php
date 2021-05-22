<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\HomeController;
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
})->middleware('auth')->name('home');

Auth::routes();

//Homepage route
Route::post('pretraga-korisnika', [HomeController::class, 'getUsers'])
    ->middleware(['auth', 'isAdmin'])->name('searchUsers');
Route::get('edit-user/{userId}', [HomeController::class, 'getUserForEdit'])
    ->middleware(['auth', 'isAdmin'])->name('getUserForEdit');

// Card routes
Route::get('/dodaj-iskaznicu', function() {
    return view('addCard');
})->middleware(['auth', 'isAdmin'])->name('addCard');
Route::get('/iskaznica/{brIskaznice}', [CardController::class, 'dohvatiProfil'])
    ->name('viewProfile');
Route::post('/dodaj-iskaznicu', [CardController::class, 'dodajIskaznicu'])
    ->middleware(['auth', 'isAdmin']);
Route::get('/edit-iskaznice/{brIskaznice}', [CardController::class, 'dohvatiProfilZaEditiranje'])
    ->middleware(['auth', 'isAdmin'])->name('editProfile');
Route::post('/edit-iskaznice/{brIskaznice}', [CardController::class, 'editProfile'])
    ->middleware(['auth', 'isAdmin'])->name('saveEditProfile');
Route::post('/izbrisi-iskaznicu/{brIskaznice}', [CardController::class, 'deleteProfile'])
    ->middleware(['auth', 'isAdmin'])->name('deleteProfile');
