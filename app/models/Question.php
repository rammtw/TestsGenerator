<?php

class Question extends Eloquent {

	/* 
	 * Подготавливает вопрос, занося его в отдельную таблицу с уникальным ключом 
	 */
	public static function prepare($test_id) {
		$question_id = Question::where('test_id', '=', $test_id)->orderBy(DB::raw('RAND()'))->pluck('id');

		$uniq_hash = sha1(uniqid());

		$row = DB::table('user_test_answers')->insert(array('user_id' => Auth::user()->id, 
															'test_id' => $test_id, 
															'question_id' => $question_id,
															'uniq_hash' => $uniq_hash
															)
													);

		return $uniq_hash;
	}

	/*
	 * Возвращает вопрос и ответы по id
	 */
	public static function get($id) {
		$question = Question::where('id', '=', $id)->first();

		return $question;
	}

	public static function setAnswer($a_indexes, $hash) {
		DB::table('user_test_answers')
					->where('user_id', '=', Auth::user()->id)
					->where('uniq_hash', '=', $hash)
					->update(array('answer' => $a_indexes));
	}

	/*
	 * Возвращает вопрос и ответы по hash
	 */
	public static function getByHash($hash) {
		$question_id = DB::table('user_test_answers')
									->where('user_id', '=', Auth::user()->id)
									->where('uniq_hash', '=', $hash)
									->pluck('question_id');

		return self::get($question_id);
	}

	public function countUserRating() {

	}

	public function countTotalInTest() {

	}

	public static function shuffle_answers($answers) { 
		$list = explode('|', $answers);

		if (!is_array($list)) return $list; 

		$keys = array_keys($list);
		shuffle($keys);
		$random = array();
		foreach ($keys as $key) {
			$random[$key] = $list[$key];
		}

		return $random;
	}

}