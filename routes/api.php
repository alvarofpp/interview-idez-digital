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

/*
 * Auth
 */
Route::group(['namespace' => 'Auth', 'prefix' => 'auth',], function () {
    Route::post('register', 'RegisterController@register')
        ->name('auth.register');
    Route::post('login', 'AuthController@login')
        ->name('auth.login');
    Route::get('logout', 'AuthController@logout')
        ->name('auth.logout');
});

Route::group(['middleware' => 'auth:api'], function () {
    /*
     * Account types
     */
    Route::apiResource('account_types', 'AccountTypeController')
        ->only(['index',]);

    /*
     * Transaction types
     */
    Route::apiResource('transaction_types', 'TransactionTypeController')
        ->only(['index',]);
});
