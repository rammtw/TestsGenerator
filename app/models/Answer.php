<?php

class Answer extends Eloquent {

	public $timestamps = false;

	public static function format(&$answers, $type) {
		foreach ($answers as $key => $answer) {
			if($type === 'input') {
				$answers[$key]['answer'] = null;
				$answers[$key]['id'] = null;
			}
		}
		return $answers;

	}

	public static function shuffle(&$list) { 
		if (!is_array($list)) return $list; 

		$keys = array_keys($list);
		shuffle($keys);
		$random = array();
		foreach ($keys as $key) {
			$random[$key] = $list[$key];
		}

		return $list = $random;
	}

}