<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
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

Auth::routes(['register' => false]);

// Homepage route
Route::post('pretraga-korisnika', [HomeController::class, 'getUsers'])
    ->middleware(['auth'])->name('searchUsers');

// User routes
Route::get('edit-user/{userId}', [HomeController::class, 'getUserForEdit'])
    ->middleware(['auth', 'canEditProfile'])->name('getUserForEdit');
Route::post('edit-user/{userId}', [UserController::class, 'editUser'])
    ->middleware(['auth', 'canEditProfile'])->name('editUser');
Route::get('add-user', [UserController::class, 'loadAddUser'])
    ->middleware(['auth', 'isSuperAdmin'])->name('loadAddUser');
Route::post('add-user', [UserController::class, 'addUser'])
    ->middleware(['auth', 'isSuperAdmin'])->name('addUser');

// Card routes
Route::get('/dodaj-iskaznicu', function() {
    return view('addCard');
})->middleware(['auth', 'changedPassword'])->name('addCard');
Route::get('/iskaznica/{brIskaznice}', [CardController::class, 'dohvatiProfil'])
    ->name('viewProfile');
Route::post('/dodaj-iskaznicu', [CardController::class, 'dodajIskaznicu'])
    ->middleware(['auth', 'changedPassword']);
Route::get('/edit-iskaznice/{brIskaznice}', [CardController::class, 'dohvatiProfilZaEditiranje'])
    ->middleware(['auth', 'changedPassword'])->name('editProfile');
Route::post('/edit-iskaznice/{brIskaznice}', [CardController::class, 'editProfile'])
    ->middleware(['auth', 'changedPassword'])->name('saveEditProfile');
Route::post('/izbrisi-iskaznicu/{brIskaznice}', [CardController::class, 'deleteProfile'])
    ->middleware(['auth', 'changedPassword'])->name('deleteProfile');
