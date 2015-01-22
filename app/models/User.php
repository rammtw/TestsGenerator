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

	public static function isStudent() {
		if(Auth::check()) {
			return Auth::user()->role_id === '1' ? true : false;
		}
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
		$this->role = 1;

		$this->save();

		return $this->id;
	}

	public function updateData() {
		$status = User::where('id', $this->id)
            				->update(array('login' => $this->login, 'name' => $this->name, 'last_name' => $this->last_name, 'group_id' => $this->group_id, 'role_id' => $this->role_id));

        return $status;
	}

	public static function getRoles() {
		$roles = DB::table('roles')->lists('type','id');

		return $roles;
	}

	public static function getDataByUserId($user_id) {
		$user = User::where('id', '=', $user_id)
		            ->select('id', 'login', 'name', 'last_name', 'group_id', 'role_id')->first();

		return $user;
	}

	public static function getPeoples() {
		$users = User::join('roles', 'roles.id', '=', 'users.role_id')
			            ->join('groups', 'groups.id', '=', 'users.group_id')
			            ->select('users.id', 'users.login', 'users.name', 'users.last_name', 'groups.name as group', 'users.register_date', 'roles.type as role')->get();

		return $users;
	}

}
