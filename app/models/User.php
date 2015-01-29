<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

    public static $validation = array(
        'login' => 'required|unique:users',

        'name'  => 'required|alpha',

        'last_name'  => 'required|alpha',

        'password'  => 'required|confirmed|min:6',

    	'group_id' => 'integer'
    );

	public $timestamps = false;

	protected $fillable = array('id', 'login', 'name', 'last_name', 'password', 'group_id', 'register_date', 'role_id');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function group() {
		return $this->belongsTo('Group');
	}

	public function role() {
		return $this->belongsTo('Role');
	}

	public static function isTeacher() {
		if(Auth::check()) {
			return Auth::user()->role_id === '2' ? true : false;
		}
	}

	public static function isAdmin() {
		if(Auth::check()) {
			return Auth::user()->role_id === '3' ? true : false;	
		}
	}

	public function register() {
		/* Хэшируем пароль */
		$this->password = Hash::make($this->password);
		/* Текущая дата */
		$this->register_date = date('Y-m-d H:i:s');
		/* По умолчанию регистрируется студент */
		$this->role_id = 1;

		$this->save();

		return $this->id;
	}

	public static function updateProfile($data) {
		$user = User::find($data['id']);
		$user->fill($data);

		return $user->save();
	}

}
