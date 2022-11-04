<?php

use Gtech\AbnayiyNotification\Controllers\UserNotificationSettingController;
use Gtech\AbnayiyNotification\Controllers\TelegramNotificationController;
use Gtech\AbnayiyNotification\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// route to recive telegram updates from webhook

Route::post('notifications/{token}/getUpdates', [TelegramNotificationController::class, 'update'])->name('ApiWebHook');

Route::prefix('notifications')->group(function () {
  
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('notificationChannels', [UserNotificationSettingController::class,'notificationChannels']);
        Route::get('userNotifications', [UserNotificationController::class,'MyNotifications']);
        Route::post('setNotificationAsSeen', [UserNotificationController::class,'setNotificationAsSeen']);
        Route::get('getSetting', [UserNotificationSettingController::class, 'edit']);
        Route::post('updateSetting', [UserNotificationSettingController::class, 'update']);
    });
});
