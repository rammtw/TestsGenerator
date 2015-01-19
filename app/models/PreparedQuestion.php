<?php

class PreparedQuestion extends Eloquent {

	/* 
	 * Подготавливает вопросы, занося их в отдельную таблицу с уникальным ключом 
	 */
	public static function prepare($test_id) {
		$test = Test::get($test_id);

		$question_ids = Question::where('test_id', '=', $test_id)->select('id')->take($test['questions_count'])->get();

		$id = UserTest::make($test_id);

		$hash = sha1(uniqid());

		foreach ($question_ids as $value) {

			$data = array(
							'user_id' => Auth::user()->id,
							'user_test_id' => $id,
							'question_id' => $value->id,
							'hash' => $hash
						);

			$row = PreparedQuestion::insert($data);
		}

		return $hash;
	}

	/*
	 * Возвращает вопрос и ответы по hash
	 */
	public static function getByHash($hash) {
		$question_id = PreparedQuestion::whereNull('a_indexes')
											->where('user_id', '=', Auth::user()->id)
											->where('hash', '=', $hash)
											->pluck('question_id');

		return Question::get($question_id);
	}

	public static function setAnswer($a_indexes, $hash) {
		$status = PreparedQuestion::where('user_id', '=', Auth::user()->id)
										->where('uniq_hash', '=', $hash)
										->update(array('answer' => $a_indexes));

		return $status;
	}

	public static function shuffleAnswers($answers) { 
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