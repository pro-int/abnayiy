<?php

use Gtech\AbnayiyNotification\Controllers\admin\AdminNotificationController;
use Gtech\AbnayiyNotification\Controllers\admin\AdminNotificationTypesController;
use Gtech\AbnayiyNotification\Controllers\admin\AdminNotificationFrequentController;
use Gtech\AbnayiyNotification\Controllers\admin\AdminNotificationChannelController;
use Gtech\AbnayiyNotification\Controllers\admin\AdminNotificationContentController;
use Gtech\AbnayiyNotification\Controllers\admin\AdminNotificationEventsController;
use Gtech\AbnayiyNotification\Controllers\admin\AdminNotificationSectionsController;
use Gtech\AbnayiyNotification\Controllers\UserNotificationController;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

Route::get('notifications/setWebhook', function ()
{    
    $res = Telegram::setWebhook([
        'url' => route('ApiWebHook', env('TELEGRAM_API_TOKEN'))
    ]);
    dd($res);
});
Route::get('notifications/sentNotifications', [UserNotificationController::class,'sentNotifications'])->name('sentNotifications');
Route::get('notifications/MyNotifications', [UserNotificationController::class,'MyNotifications'])->name('MyNotifications');
Route::get('notifications/{user_id}/UserNotifications', [UserNotificationController::class,'UserNotifications'])->name('UserNotifications');
Route::resource('notifications/sections.events', AdminNotificationEventsController::class);
Route::resource('notifications/sections', AdminNotificationSectionsController::class);
Route::resource('notifications.types.frequent', AdminNotificationFrequentController::class);
Route::resource('notifications.types', AdminNotificationTypesController::class);
Route::resource('notifications/contents', AdminNotificationContentController::class);
Route::resource('notifications/channels', AdminNotificationChannelController::class);
Route::resource('notifications', AdminNotificationController::class);
route::post('notifications/events/getSectionEvents', [AdminNotificationController::class, 'getSectionEvents']);


