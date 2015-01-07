<?php

class Group extends Eloquent {

	public $timestamps = false;

	protected $guarded = array('id', 'name');

	public function users() {
		return $this->hasMany('User');
	}

}
