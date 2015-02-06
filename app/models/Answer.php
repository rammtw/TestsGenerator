<?php

class Answer extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('id', 'question_id', 'answer', 'r');

	public function question() {
		return $this->belongsTo('Question');
	}

	public function make($question_id, $answer) {
		$this->question_id = $question_id;

		$this->answer = $answer;

		$this->save();

		return $this->id;
	}

	public function updateCorrect($question_id, $answers, $r_indexes) {
		foreach ($answers as $key => $answer) {

			$a = new Answer;

			$id = $a->make($question_id, $answer);

			if(in_array($key, $r_indexes)) {

				$this->setCorrect($id);

				Test::incAnswerPoints();

			}
		}
	}

	public function setCorrect($id) {
		$answer = $this->find($id);

		$answer->r = 1;

		$answer->save();
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