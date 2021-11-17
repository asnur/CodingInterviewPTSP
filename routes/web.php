<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\UmkmController;
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

Route::get('/', [LoginController::class, 'ShowLoginForm']);

Route::get('/auth/redirect', [SocialiteController::class, 'redirectToProvider'])->name('login-google');

Route::get('/auth/callback', [SocialiteController::class, 'handleProviderCallback']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/save-location', [UmkmController::class, 'store'])->name('save-location');
Route::get('/get-data-location', [UmkmController::class, 'get_data'])->name('get-data-location');
