<?php

class Question extends Eloquent {

	/*
	 * Возвращает вопрос и ответы по id
	 */
	public static function get($id) {
		$question = Question::where('id', '=', $id)->first();

		return $question;
	}

	/*
	 * Возвращает вопрос и ответы по hash
	 */
	public static function getByHash($hash) {
		$question_id = PreparedQuestion::where('user_id', '=', Auth::user()->id)
											->where('uniq_hash', '=', $hash)
											->pluck('question_id');

		return self::get($question_id);
	}

    public function countUserRating() {

	}

	public function countTotalInTest() {

	}

}