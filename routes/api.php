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

Route::group( [ 'middleware' => 'auth:api' ],
	function () {
		Route::post( 'logout', 'Auth\LoginController@logout' );

		Route::get( '/user',
			function ( Request $request ) {
				return $request->user();
			} );

		Route::patch( 'settings/profile', 'Settings\ProfileController@update' );
		Route::patch( 'settings/password', 'Settings\PasswordController@update' );
	} );

Route::group( [ 'middleware' => 'guest:api' ],
	function () {
		Route::post( 'login', 'Auth\LoginController@login' );
		Route::post( 'register', 'Auth\RegisterController@register' );
		Route::post( 'password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail' );
		Route::post( 'password/reset', 'Auth\ResetPasswordController@reset' );

		Route::post( 'oauth/{driver}', 'Auth\OAuthController@redirectToProvider' );
		Route::get( 'oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback' )->name( 'oauth.callback' );
		Route::get( 'schedules', \App\Http\Controllers\Schedules\Index::__getClassNameSpace() );

		Route::prefix( 'teams' )->group(
			function () {
				Route::post( '/register', \App\Http\Controllers\Teams\Create::__getClassNameSpace() );
				Route::get( '/{guid}/participants', \App\Http\Controllers\Teams\Participants::__getClassNameSpace() );
				Route::get( '/{guid}/picks', \App\Http\Controllers\Teams\Picks::__getClassNameSpace() );
				Route::get( '/{guid}/picks/available', \App\Http\Controllers\Teams\AvailablePicks::__getClassNameSpace() );
				Route::get( '/{guid}', \App\Http\Controllers\Teams\Get::__getClassNameSpace() );
			}
		);

		Route::prefix( 'participants' )->group(
			function () {
				Route::post( '/pick/{guid}/{schedule_id}', \App\Http\Controllers\Participants\Pick::__getClassNameSpace() );
				Route::post( '/{guid}/confirm', \App\Http\Controllers\Participants\Confirm::__getClassNameSpace() );
			}
		);
	} );
