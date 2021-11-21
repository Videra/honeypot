<?php

use App\Http\Controllers\AdminController;
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
    return view('layouts.app');
});

Auth::routes([
    'reset' => false,
    'confirm' => false,
    'verify' => false,
]);

Route::get('home', [UserController::class, 'show'])->name('home');
Route::post('home', [UserController::class, 'upload'])->name('upload');

Route::get('sessions', [SessionsController::class, 'show'])->name('sessions');
Route::delete('sessions/{id}', [SessionsController::class, 'delete'])->name('sessions.delete');

Route::get('users', [AdminController::class, 'show'])->name('users');
Route::get('users/admin', [AdminController::class, 'showAdmin'])->name('users.admin');
Route::get('users/active', [AdminController::class, 'showActive'])->name('users.active');
Route::get('users/enabled', [AdminController::class, 'showEnabled'])->name('users.enabled');
Route::get('users/disabled', [AdminController::class, 'showDisabled'])->name('users.disabled');
Route::put('users/{id}/enable', [AdminController::class, 'enable'])->name('users.enable');
Route::put('users/{id}/disable', [AdminController::class, 'disable'])->name('users.disable');
Route::delete('users/{id}/delete', [AdminController::class, 'delete'])->name('users.delete');
