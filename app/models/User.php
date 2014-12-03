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

	public function register() {
		/* Хэшируем пароль */
		$this->password = Hash::make($this->password);
		/* Текущая дата */
		$this->register_date = date('Y-m-d H:i:s');
		/* По умолчанию регистрируется студент */
		$this->role = 1;

		$this->save();

		return $this->id;
	}

	public static function isTeacher() {

		return Auth::user()->role === '2' ? true : false;

	}

}
