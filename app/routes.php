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

Route::get('logout', 'UserController@logout');

Route::when('*', 'csrf', array('post'));

/**********************************************************************************
 ************************ GUEST ZONE **********************************************
 **********************************************************************************
 */

Route::group(array('before' => 'guest'), function() {

	// Страница регистрации
	Route::get('reg', 'UserController@register');

	// Страница авторизации
	Route::get('sign', 'UserController@sign');

	// Регистрация
	Route::post('u/create', 'UserController@create');

	// Авторизация
	Route::post('u/auth', 'UserController@auth');

});

/**********************************************************************************
 ************************ AUTH ZONE ***********************************************
 **********************************************************************************
 */

Route::group(array('before' => 'auth'), function() {

	// Инфо по тесту
	Route::get('test/{test_id}', 'TestController@index')->where(array('test_id' => '[0-9]+'));

	Route::get('test/subject/all', 'TestController@allSubjects');

	Route::get('u/finished', 'UserController@finished');

	// Страница с вопросом
	Route::get('q/{id}', array('as' => 'quest', 'uses' => 'QuestionController@question'))->where(array('id' => '[0-9]+'));

	// Подготовить вопрос
	Route::post('q/p', 'QuestionController@prepare');

	// Установить ответ
	Route::post('q/a/set', 'QuestionController@setAnswer');

});


/**********************************************************************************
 ************************ TEACHER ZONE ********************************************
 **********************************************************************************
 */
Route::group(array('before' => 'teacher,admin'), function() {

	// Мои созданные тесты
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

	// CRUD операции
	Route::post('test/do', 'TestController@doAction');

	// Создание предмета
	Route::post('test/subject/create', 'TestController@createSubject');

	Route::post('test/q/create', 'QuestionController@create');

});

/**********************************************************************************
 ************************ ADMIN ZONE **********************************************
 **********************************************************************************
 */
Route::when('admin/*', 'admin');

// Список пользователей
Route::get('admin/people', 'AdminController@people');

// Редактировать юзера
Route::get('admin/edit/{user_id}', 'AdminController@edit');

// Обновить данные юзера
Route::post('admin/user/update', 'AdminController@update');