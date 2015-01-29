<?php

/**
* Admin
*/
class AdminController extends BaseController {

	public function people() {
		$users = User::all();

		return View::make('admin.people', array('users' => $users));
	}

	public function edit($user_id) {
		$user = User::find($user_id);
		$groups = Group::lists('name','id');
		$roles = Role::lists('type','id');

		return View::make('admin.edit', array('user' => $user, 'groups' => $groups, 'roles' => $roles));
	}

	public function update() {
		User::updateProfile(Input::all());

		return Redirect::to('admin/people')->with('message', 'Сохранено!');
	}

}