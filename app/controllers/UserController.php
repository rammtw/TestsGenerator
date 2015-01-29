<?php

class UserController extends BaseController {

	public function register() {
		$groups = Group::lists('name','id');

		return View::make('user.register', array('groups' => $groups));
	}

	public function create() {
		$rules = User::$validation;

		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails()) {
			return Redirect::to('reg')->withErrors($validation)->withInput();
		}

		$user = new User;
		$user->fill(Input::all());
		$id = $user->register();

		$user = User::find($id);
		Auth::login($user, true);

		return Redirect::to('/');
	}

	public function sign() {
		return View::make('user.sign');
	}

	public function auth() {
		$creds = Input::all();

		if(Auth::attempt(array('login' => $creds['login'], 'password' => $creds['password']), Input::has('remember'))) {
			return Redirect::intended();
		}

		return Redirect::back()->with("error", 1);
	}

	public function logout() {
		Auth::logout();
		return Redirect::to('/');
	}

	public function finished() {
		$user_tests = UserTest::getFinished(Auth::user()->id);

		return View::make('user.finished', array('user_tests' => $user_tests));
	}

}