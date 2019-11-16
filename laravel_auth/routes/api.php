<?php

use Illuminate\Http\Request;

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

Route::namespace('api')->group(function () {
    // [OAUTH] Méthode login re-codé pour exporter le group de l'utilisateur
    // [OAUTH] Sinon réactiver Passport::routes() dans AuthServiceProvider
    //Route::post('login_sans_idclient', 'AuthController@login')->name('login2');
    Route::post('login', 'LoginController@issueToken')->name('login');

    // [OAUTH] Inscription d'un nouvel utilisateur sans authentification
    Route::post('signup', 'UserController@signup')->name('signup');

    // [OAUTH] Routes accessible qu'après authentification avec token valide
    Route::group(['middleware' => 'auth:api'], function() {

        // [OAUTH] [ROLE] uniquement par un utilisateur admin
        Route::middleware('can:accessAdminpanel')->group(function() {
            // [OAUTH] [ROLE] Inscription d'un nouvel utilisateur que pour les admins
            //Route::post('signup', 'AuthController@signup');
            Route::get('user', 'UserController@user')->name('admin.user');
        });

        Route::get('menu', 'UserController@menu')->name('auth.menu');
        Route::get('logout', 'UserController@logout')->name('auth.logout');
    });
});


