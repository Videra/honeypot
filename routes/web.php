<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttemptController;
use App\Http\Controllers\ChallengesController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [UsersController::class, 'index'])->name('users.challenges')
    ->withoutMiddleware(['auth', 'enabled']);

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('/home', function () {
    return redirect()->to('challenges');
})->name('home');

Route::get('attempts', [AttemptController::class, 'index'])->name('attempts.index');

Route::get('challenges', [ChallengesController::class, 'index'])->name('challenges.index');
Route::post('challenges', [ChallengesController::class, 'attempt'])->name('challenges.attempt');

Route::get('profile', [UsersController::class, 'show'])->name('user.show');
Route::post('profile', [UsersController::class, 'update'])->name('user.update');

Route::get('sessions', [SessionsController::class, 'index'])->name('sessions');
Route::delete('sessions/{id}', [SessionsController::class, 'delete'])->name('sessions.delete');

Route::get('sessions/user/{user_id}', [SessionsController::class, 'show'])->name('sessions.user')
    ->middleware('admin');

Route::get('users', [AdminController::class, 'index'])->name('users.index');
Route::get('users/user', [AdminController::class, 'indexUsers'])->name('users.user');
Route::get('users/admin', [AdminController::class, 'indexAdmins'])->name('users.admin');
Route::get('users/active', [AdminController::class, 'indexLoggedIn'])->name('users.active');
Route::get('users/enabled', [AdminController::class, 'indexEnabled'])->name('users.enabled');
Route::get('users/disabled', [AdminController::class, 'indexDisabled'])->name('users.disabled');
Route::put('users/{id}/enable', [AdminController::class, 'enable'])->name('users.enable');
Route::put('users/{id}/disable', [AdminController::class, 'disable'])->name('users.disable');
Route::delete('users/{id}/delete', [AdminController::class, 'delete'])->name('users.delete');
