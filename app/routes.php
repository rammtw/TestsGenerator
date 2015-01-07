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

Route::when('admin/*', 'admin');

Route::get('logout', 'UserController@logout');

Route::group(array('before' => 'guest'), function() {

	Route::get('reg', 'UserController@register');
	Route::get('sign', 'UserController@sign');

});

Route::group(array('before' => 'csrf'), function() {

	Route::post('reg/create', 'UserController@create');
	Route::post('sign/auth', 'UserController@auth');

	Route::post('admin/update', 'AdminController@update');

});

Route::get('admin/people', 'AdminController@people');
Route::get('admin/edit/{user_id}', 'AdminController@edit');

Route::group(array('before' => 'teacher'), function() {

	Route::get('test/my', 'TestController@my');

	Route::get('test/new', 'TestController@build');

	Route::get('test/edit/{test_id}', 'TestController@edit');

	Route::get('test/subject/new', function() {
		return View::make('test.new_subject');
	});

	Route::group(array('before' => 'csrf'), function() {
		Route::post('test/do', 'TestController@doAction');
		Route::post('test/subject/create', 'TestController@createSubject');
	});
	
});