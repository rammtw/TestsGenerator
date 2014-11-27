<?php

class AuthController extends BaseController {

	public function register() {
		$groups = Group::lists('name','id');
		return View::make('auth.register', array('groups' => $groups));
	}

	public function createUser() {
		/*
			Регистрация TODO: validations
		*/	
		$data = Input::except('_token');

		$user = new User;
		$user->register($data);

		return 'WellDone!';
	}

	public function auth() {
		echo 'auth';
	}
}