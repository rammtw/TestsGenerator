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
Route::when('test/*', 'auth');
Route::when('q/*', 'auth');

Route::get('logout', 'UserController@logout');

Route::group(array('before' => 'guest'), function() {

	Route::get('reg', 'UserController@register');
	Route::get('sign', 'UserController@sign');

});

Route::group(array('before' => 'csrf'), function() {

	Route::post('reg/create', 'UserController@create');
	Route::post('sign/auth', 'UserController@auth');

	Route::post('admin/update', 'AdminController@update');

	Route::post('q/p', 'QuestionController@prepare');

	Route::post('q/a/set', 'QuestionController@setAnswer');

});

Route::get('admin/people', 'AdminController@people');
Route::get('admin/edit/{user_id}', 'AdminController@edit');

Route::get('test/{test_id}', 'TestController@info')->where(array('test_id' => '[0-9]+'));

Route::get('q/{hash}', 'QuestionController@question')->where(array('hash' => '\b[0-9a-f]{5,40}\b'));

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