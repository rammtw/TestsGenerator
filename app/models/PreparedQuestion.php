<?php

class PreparedQuestion extends Eloquent {

	public $timestamps = false;

	/* 
	 * Подготавливает вопрос, занося его в отдельную таблицу с уникальным ключом 
	 */
	public static function prepare($test_id) {
		$question_id = Question::where('test_id', '=', $test_id)->orderBy(DB::raw('RAND()'))->pluck('id');

		$uniq_hash = sha1(uniqid());

		$row = PreparedQuestion::insert(array('user_id' => Auth::user()->id, 
											'test_id' => $test_id, 
											'question_id' => $question_id,
											'uniq_hash' => $uniq_hash
											)
									);

		return $uniq_hash;
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