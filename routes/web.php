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
})->middleware('auth', 'isDisabled')->name('home');

Auth::routes(['register' => false, 'reset' => false]);

// Homepage routes
Route::post('pretraga-korisnika', [HomeController::class, 'getUsers'])
    ->middleware(['auth'])->name('searchUsers');

// Admin routes
Route::get('edit-user/{userId}', [HomeController::class, 'getUserForEdit'])
    ->middleware(['auth', 'isDisabled', 'canEditProfile'])->name('getUserForEdit');
Route::post('edit-user/{userId}', [UserController::class, 'editUser'])
    ->middleware(['auth', 'isDisabled', 'canEditProfile'])->name('editUser');
Route::get('add-user', [UserController::class, 'loadAddUser'])
    ->middleware(['auth', 'isSuperAdmin'])->name('loadAddUser');
Route::post('add-user', [UserController::class, 'addUser'])
    ->middleware(['auth', 'isSuperAdmin'])->name('addUser');
Route::post('disableAdmin/{userId}', [UserController::class, 'disableAdmin'])
    ->middleware(['auth', 'isSuperAdmin'])->name('disableAdmin');
Route::post('enableAdmin/{userId}', [UserController::class, 'enableAdmin'])
    ->middleware(['auth', 'isSuperAdmin'])->name('enableAdmin');

// Card routes
Route::get('/dodaj-iskaznicu', function() {
    return view('addCard');
})->middleware(['auth', 'isDisabled', 'changedPassword'])->name('addCard');
Route::get('/iskaznica/{brIskaznice}', [CardController::class, 'dohvatiProfil'])
    ->name('viewProfile');
Route::post('/dodaj-iskaznicu', [CardController::class, 'dodajIskaznicu'])
    ->middleware(['auth', 'isDisabled', 'changedPassword']);
Route::get('/edit-iskaznice/{brIskaznice}', [CardController::class, 'dohvatiProfilZaEditiranje'])
    ->middleware(['auth', 'isDisabled', 'changedPassword'])->name('editProfile');
Route::post('/edit-iskaznice/{brIskaznice}', [CardController::class, 'editProfile'])
    ->middleware(['auth', 'isDisabled', 'changedPassword'])->name('saveEditProfile');
Route::post('/izbrisi-iskaznicu/{brIskaznice}', [CardController::class, 'deleteProfile'])
    ->middleware(['auth', 'isDisabled', 'changedPassword'])->name('deleteProfile');
