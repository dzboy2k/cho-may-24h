<?php

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

Route::group(['prefix' => '/v1', 'namespace' => 'API\Site'], function () {
    Route::group(['prefix' => '/notifications'], function () {
        Route::post('/add', 'NotificationController@createNotification')->name('api_notification_add');
        Route::post('/read', 'NotificationController@readNotification')->name('api_notification_read');
        Route::get('/', 'NotificationController@getNotificationList')->name('api_notification_list_more');
    });
    Route::group(['prefix' => '/chats'], function () {
        Route::post('/new-contact', 'ChatController@newContact')->name('api.chat.contact.new');
        Route::get('/contacts/{contact_id}/read', 'ChatController@readContact')->name('api.chat.contact.read');
        Route::post('/send', 'ChatController@send')->name('api.chat.send');
        Route::get('/contacts/user/{user_id}', 'ChatController@getContactByUser')->name('api.chat.list_contact');
        Route::get('/contacts/{contact_id}/messages', 'ChatController@getMessageByContact')->name('api.chat.list_message');
        Route::get('/contacts/{contact_id?}', 'ChatController@getContactByReceiverId')->name('api.chat.contact');
        Route::get('/contact/{contact_id?}/delete', 'ChatController@deleteContact')->name('api.chat.delete');
    });
    Route::group(['prefix' => '/order'], function () {
        Route::post('/new-order', 'OrderController@createOrder')->name('api.order.create');
    });
    Route::group(['prefix' => '/support'], function () {
        Route::get('/check-transfer-target', 'SupportTransactionController@checkUserTargetToTransfer')->name('support.check.transfer.target');
    });
    Route::post('/upload', 'ImageController@upload')->name('api.images.upload');
    Route::post('/casso-webhook', 'CassoWebhookController@balanceFluctuations')->middleware('casso.check.auth')->name('api.transactions.fluctuations')->withoutMiddleware('auth.api');
    Route::post('/saved-posts/toggle-save/{id}', 'SavedPostController@toggleSave')->name('toggle.save.post');
});
