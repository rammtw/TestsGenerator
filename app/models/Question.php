<?php

class Question extends Eloquent {

	public function answers() {
		return $this->hasMany('Answer');
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

}