<?php

/**
* Admin
*/
class AdminController extends BaseController {

	public function people() {
		$users = Cache::remember('users', 1, function () {
			return User::getPeoples();
		});

		return View::make('admin.people', array('users' => $users));
	}

	public function edit($user_id) {
		$user = User::getDataByUserId($user_id);
		$groups = Group::lists('name','id');
		$roles = User::getRoles();

		return View::make('admin.edit', array('user' => $user, 'groups' => $groups, 'roles' => $roles));
	}

	public function update() {
		$user = new User;
		$user->fill(Input::all());
		$user->updateData();

		return Redirect::to('admin/people')->with('message', 'Сохранено!');
	}

}