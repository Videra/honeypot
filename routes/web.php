<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChallengesController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
    return view('app');
});

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', function () {
    return redirect()->to('challenges');
})->name('home');

Route::get('challenges', [ChallengesController::class, 'index'])->name('challenges.index');
Route::post('challenges', [ChallengesController::class, 'attempt'])->name('challenges.attempt');

Route::get('profile', [UserController::class, 'show'])->name('profile');
Route::post('profile', [UserController::class, 'save'])->name('profile');

Route::get('sessions', [SessionsController::class, 'index'])->name('sessions');
Route::delete('sessions/{id}', [SessionsController::class, 'delete'])->name('sessions.delete');

Route::get('sessions/user/{user_id}', [SessionsController::class, 'show'])->name('sessions.user')
    ->middleware('admin');

Route::get('users', [AdminController::class, 'show'])->name('users');
Route::get('users/user', [AdminController::class, 'showUser'])->name('users.user');
Route::get('users/admin', [AdminController::class, 'showAdmin'])->name('users.admin');
Route::get('users/active', [AdminController::class, 'showActive'])->name('users.active');
Route::get('users/enabled', [AdminController::class, 'showEnabled'])->name('users.enabled');
Route::get('users/disabled', [AdminController::class, 'showDisabled'])->name('users.disabled');
Route::put('users/{id}/enable', [AdminController::class, 'enable'])->name('users.enable');
Route::put('users/{id}/disable', [AdminController::class, 'disable'])->name('users.disable');
Route::delete('users/{id}/delete', [AdminController::class, 'delete'])->name('users.delete');
