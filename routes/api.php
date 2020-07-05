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
