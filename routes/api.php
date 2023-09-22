<?php

use Illuminate\Http\Request;
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

Route::namespace('Api')->group(function () {
    Route::prefix('mkc')->group(function () {
        Route::prefix('public')->group(function () {

            Route::get('ping', 'MkcController@responsePing');

            //Webhook listener   **acá le va a pegar el gateway con los eventos que se registren**
            Route::post('webhook-listener/{callback}', 'WebhookController@handle');

            Route::middleware('auth.services_access')->group(function () {
                Route::prefix('ens')->group(function () {

                    //Callback endpoints
                    Route::post('callback', 'CallbackController@create');
                    Route::put('callback', 'CallbackController@update');
                    Route::get('callback', 'CallbackController@getAll');
                    Route::post('callback/verify', 'CallbackController@verify');
                    Route::get('callback/{callbackId}', 'CallbackController@get');
                    Route::delete('callback/{callbackId}', 'CallbackController@delete');

                    //subscription endpoints
                    Route::post('subscription', 'SubscriptionController@create');
                    Route::put('subscription', 'SubscriptionController@update');
                    Route::get('subscription/by-callback/{callbackId}', 'SubscriptionController@getByCallbackId');
                    Route::get('subscription/{subscriptionId}', 'SubscriptionController@get');
                    Route::delete('subscription/{subscriptionId}', 'SubscriptionController@delete');

                });

            });
        });
    });
});
