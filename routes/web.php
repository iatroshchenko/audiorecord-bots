<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\StartController;
use App\Http\Controllers\Service\EmailVerificationController;
use App\Http\Controllers\LoginController;

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

Route::get('/', [PageController::class, 'index'])
    ->middleware([
        'auth'
    ])
    ->name('index');

Route::get('about', [PageController::class, 'about'])->name('about');
Route::get('login', [PageController::class, 'login'])
    ->name('login')
    ->middleware([
        'guest',
        'redirect-to-start-if-not-started'
    ]);
Route::post('login', [LoginController::class, 'login'])
    ->name('login.authenticate')
    ->middleware([
        'guest',
        'error-if-not-started'
    ]);

/* Start */
Route::get('start', [PageController::class, 'start'])->name('start.form');
Route::post('start', [StartController::class, 'start'])->name('start.submit');

/* Email Verification */
Route::get('email/notice', [EmailVerificationController::class, 'displayNotice'])
    ->name('verification.notice');
Route::get('email/verify', [EmailVerificationController::class, 'verifyEmail'])
    ->name('verification.verify')
    ->middleware(['signed']);

/* Pages */
Route::get('records', [PageController::class, 'records'])
    ->name('pages.records')
    ->middleware('auth');
