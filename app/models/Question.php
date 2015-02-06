<?php

class Question extends Eloquent {

	public $timestamps = false;

	protected $fillable = array('id', 'test_id', 'title', 'type');

	public function answers() {
		return $this->hasMany('Answer');
	}

	public function prepared_questions() {
		return $this->hasMany('PreparedQuestion');
	}

	/*
	 * Возвращает вопрос
	 */
	public static function get($id) {
		$question = Question::where('id', '=', $id)->first();

		return $question;
	}

	public static function getAnswers($question_id) {
		$answers = Question::find($question_id)->answers;

		return json_decode($answers, true);
	}

	public function make() {
		$this->test_id = Session::get('test_id');

		if($this->save()) {
			Test::incQuestionCount();
		}

		return $this->id;
	}

}