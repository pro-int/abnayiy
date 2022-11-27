<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\guardian\GuardianAuthController;


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
    return redirect()->route('home');
});

Route::prefix('parent')->group(function () {
    Route::get('login', [GuardianAuthController::class, 'showLoginPage'])->name("showLoginPage");
    Route::get('register', [GuardianAuthController::class, 'showRegistrationPage'])->name("showRegistrationPage");
    Route::post('userLogin', [GuardianAuthController::class, 'userLogin'])->name("userLogin");
    Route::post('userRegistration', [GuardianAuthController::class, 'userRegistration'])->name("userRegistration");
    Route::get('forgot-password', [GuardianAuthController::class, 'showForgotPasswordPage'])->name("showForgotPasswordPage");
    Route::post('forgotPassword', [GuardianAuthController::class, 'sendPasswordResetCode'])->name("forgotPassword");
});
