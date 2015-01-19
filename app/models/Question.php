<?php

class Question extends Eloquent {

	/*
	 * Возвращает вопрос и ответы по id
	 */
	public static function get($id) {
		$question = Question::where('id', '=', $id)->first();

		return $question;
	}

}