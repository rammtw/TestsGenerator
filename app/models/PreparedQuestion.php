<?php

class PreparedQuestion extends Eloquent {

	public $timestamps = false;

	/* 
	 * Подготавливает вопросы, занося их в отдельную таблицу
	 */
	public function prepare($test_id) {
		$test = Test::get($test_id);

		$ut = new UserTest;
		$id = $ut->make($test_id);

		Session::put('cur_test', $id);

		$question_ids = Question::where('test_id', '=', $test_id)->select('id')->take($test['questions_count'])->get();

		foreach ($question_ids as $value) {

			$data = array(
							'user_id' => Auth::user()->id,
							'user_test_id' => $id,
							'question_id' => $value->id
						);

			PreparedQuestion::insert($data);
		}

		return $id;
	}

	public function getRand($id) {
		$id = PreparedQuestion::orderBy(DB::raw('RAND()'))
											->whereNull('a_indexes')
											->where('current', '=', 0)
											->where('user_id', '=', Auth::user()->id)
											->where('user_test_id', '=', $id)
											->pluck('id');

		return $id;
	}

	/*
	 * Возвращает вопрос
	 */
	public function getCurrent($id) {
		$current = PreparedQuestion::where('current', '=', 1)
											->where('user_id', '=', Auth::user()->id)
											->where('user_test_id', '=', $id)
											->get(array('id', 'question_id'))->toArray();

		if(!$current) {
			return false;
		}

		Session::put('cur_question', $current[0]);

		return $current[0];
	}

	public function setCurrent($id) {
		$id = $this->getRand($id);

		return PreparedQuestion::where('id', '=', $id)->update(array('current' => 1));
	}

	public function refreshCurrent($id) {
		$current = $this->getCurrent($id);

		return PreparedQuestion::where('id', '=', $current['id'])->update(array('current' => 0));
	}

	public static function setAnswer($a_indexes) {
		$status = PreparedQuestion::where('user_id', '=', Auth::user()->id)
										->where('id', '=', Session::get('cur_question.id'))
										->update(array('a_indexes' => $a_indexes));

		return $status;
	}

}