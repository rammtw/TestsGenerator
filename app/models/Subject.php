<?php 

class Subject extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('id', 'name');

	public function tests() {
		return $this->hasMany('Test');
	}

	public function make() {
		return self::create(array('name' => $this->name));
	}

	public static function getList() {
		return self::lists('name','id');
	}
}