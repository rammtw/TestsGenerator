<?php

class PreparedQuestion extends Eloquent {

	public $timestamps = false;

	/* 
	 * Подготавливает вопросы, занося их в отдельную таблицу
	 */
	public function prepare($test_id) {
		$questions_count = Test::find($test_id)->pluck('questions_count');

		$ut = new UserTest;
		$id = $ut->make($test_id);

		Session::put('user_test', $id);

		$question_ids = Question::where('test_id', '=', $test_id)->select('id')->take($questions_count)->get();

		foreach ($question_ids as $value) {

			$data = array(
							'user_id' => Auth::user()->id,
							'user_test_id' => $id,
							'question_id' => $value->id
						);

			PreparedQuestion::insert($data);
		}

		$this->setCurrent($id);

		return $id;
	}

	public function getRand($user_test_id) {
		$id = PreparedQuestion::orderBy(DB::raw('RAND()'))
											->whereNull('a_indexes')
											->where('current', '=', 0)
											->where('user_id', '=', Auth::user()->id)
											->where('user_test_id', '=', $user_test_id)
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

		Session::put('cur_prepared', $current[0]);

		return $current[0];
	}

	public function setCurrent($user_test_id) {
		$id = $this->getRand($user_test_id);

		return PreparedQuestion::where('id', '=', $id)->update(array('current' => 1));
	}

	public function refreshCurrent($id) {
		$current = $this->getCurrent($id);

		$c = PreparedQuestion::where('id', '=', $current['id'])->update(array('current' => 0));

		if($c) {
			return $this->setCurrent($id);
		}
		return false;
	}

	public function setAnswer($a_indexes) {
		$answers = implode(',', $a_indexes);

		$status = PreparedQuestion::where('user_id', '=', Auth::user()->id)
										->where('id', '=', Session::get('cur_prepared.id'))
										->update(array('a_indexes' => $answers));

		return $status;
	}

	public function getAnswered($id) {
		return PreparedQuestion::whereNotNull('a_indexes')
									->where('user_test_id', '=', $id)->lists('a_indexes', 'question_id');
	}

}