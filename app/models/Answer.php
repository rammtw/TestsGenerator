<?php

class Answer extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('id', 'question_id', 'answer', 'r');

	public function question() {
		return $this->belongsTo('Question');
	}

	public function make($q_id, $answer) {
		$this->question_id = $q_id;

		$this->answer = $answer;

		$this->save();

		return $this->id;
	}

	public static function setRight($index) {
		return Answer::where('id', '=', $index)
						->update(array('r' => 1));
	}

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