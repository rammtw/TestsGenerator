<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	public $timestamps = false;

	protected $fillable = array('id', 'name', 'last_name', 'password', 'group_id', 'register_date', 'role');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function register($data) {
		/* Текущая дата */
		$data['register_date'] = date('Y-m-d H:i:s');

		/* По умолчанию регистрируется студент */
		$data['role'] = 1;

		$this->fill($data);
		$this->save();
	}

}
