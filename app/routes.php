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
Route::when('q/*', 'auth');

Route::get('logout', 'UserController@logout');

// Гость
Route::group(array('before' => 'guest'), function() {

	// Страница регистрации
	Route::get('reg', 'UserController@register');

	// Страница авторизации
	Route::get('sign', 'UserController@sign');

});

Route::group(array('before' => 'csrf'), function() {

	// Регистрация
	Route::post('u/create', 'UserController@create');

	// Авторизация
	Route::post('u/auth', 'UserController@auth');

	// Обновить данные юзера
	Route::post('admin/user/update', 'AdminController@update');

	// Подготовить вопрос
	Route::post('q/p', 'QuestionController@prepare');

	// Установить ответ
	Route::post('q/a/set', 'QuestionController@setAnswer');

});

// Список пользователей
Route::get('admin/people', 'AdminController@people');

// Редактировать юзера
Route::get('admin/edit/{user_id}', 'AdminController@edit');

// Инфо по тесту
Route::get('info/{test_id}', array('before' => 'auth', 'uses' => 'TestController@info'))->where(array('test_id' => '[0-9]+'));

// Страница с вопросом
Route::get('q/{id}', array('as' => 'quest', 'uses' => 'QuestionController@question'))->where(array('id' => '[0-9]+'));


Route::group(array('before' => 'auth'), function() {

	Route::get('u/finished', 'UserController@finished');

});

Route::get('subject/all', 'TestController@allSubjects');

/**********************************************************************************
 ************************ TEACHER ZONE ********************************************
 **********************************************************************************
 */
Route::group(array('before' => 'teacher'), function() {

	// Мои тесты
	Route::get('test/my', 'TestController@my');

	// Создать тест
	Route::get('test/new', 'TestController@build');

	// Редактировать тест
	Route::get('test/edit/{test_id}', 'TestController@edit');

	Route::get('test/q/{test_id}', 'QuestionController@make');

	// Создать предмет
	Route::get('test/subject/new', function() {
		return View::make('subject.new');
	});

	Route::group(array('before' => 'csrf'), function() {

		// CRUD операции
		Route::post('test/do', 'TestController@doAction');

		// Создание предмета
		Route::post('test/subject/create', 'TestController@createSubject');

		Route::post('test/q/create', 'QuestionController@create');

	});
	
});