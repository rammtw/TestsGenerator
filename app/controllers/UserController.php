<?php

class UserController extends BaseController {

	public function register() {
		if (!Auth::check()) {
			$groups = Group::lists('name','id');
			return View::make('user.register', array('groups' => $groups));	
		}else {
			return Redirect::to('/');
		}
		
	}

	public function create() {
		/*
			Регистрация TODO: validations
		*/	

		$user = new User;
		$user->fill(Input::all());
		$id = $user->register();

		$user = User::find($id);
		Auth::login($user, true);

		return Redirect::to('/');
	}

	public function auth() {
		echo 'auth';
	}

}