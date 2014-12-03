<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('/logout', 'UserController@logout');

Route::group(array('before' => 'guest'), function() {
	Route::get('/reg', 'UserController@register');
	Route::get('/sign', 'UserController@sign');
});

Route::group(array('before' => 'csrf'), function() {
	Route::post('/reg/create', 'UserController@create');
	Route::post('/sign/auth', 'UserController@auth');
});