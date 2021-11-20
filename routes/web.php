<?php

use App\Http\Controllers\AdminController;
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

Route::get('admin', [AdminController::class, 'show'])->name('admin');
Route::put('admin/users/{id}/enable', [AdminController::class, 'enable'])->name('users.enable');
Route::put('admin/users/{id}/disable', [AdminController::class, 'disable'])->name('users.disable');
