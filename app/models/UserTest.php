<?php

class UserTest extends Eloquent {

	public $results = array();

	public $table = 'user_tests';

	private static $criteria = array(
                                        2 => array(0, 49),
                                        3 => array(50, 69),
                                        4 => array(70, 89),
                                        5 => array(90, 100)
                                   );

	public function preparedQuestions() {
		return $this->hasMany('PreparedQuestion');
	}

	public function test() {
		return $this->belongsTo('Test');
	}

	public function make($test_id) {
		$this->user_id = Auth::user()->id;
		$this->test_id = $test_id;

		$this->save();

		return $this->id;
	}

	public function finish($id) {
		$this->countTotalInTest($id);
		$this->countUserRating($id);

		Session::forget('user_test');
		Session::forget('cur_prepared');

		return UserTest::where('id', '=', $id)
							->update(array('finished' => 1));
	}

	public static function updateUserRating($id, $rating) {
		return UserTest::where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->update(array('rating' => $rating));
	}

    public function countUserRating($id) {

    	$percent = $this->getPercent($id);

    	foreach (self::$criteria as $r => $range) {
    		foreach ($range as $i => $value) {
    			if ($i === 0 && $percent >= $value && $percent <= $range[$i + 1])
    				$rating = $r;
    		}
    	}

    	return self::updateUserRating($id, $rating);
	}

	public function countTotalInTest($id) {
		$prep = new PreparedQuestion;

		$answered = $prep->getAnswered($id);

		foreach ($answered as $key => $answer) {
			$a[$key] = explode('|', $answer); // Эксплоудим ответы, т.к они хранятся через |
		}

		foreach ($a as $key => $value) {
			foreach ($value as $value2) {
				$r = Answer::where('question_id', '=', $key)
								->where('answer', '=', $value2)
								->pluck('r');
				if($r == true)
					$this->setCorrect();
				else
					$this->setInCorrect();
			}
		}
	}

	public function setCorrect() {
		return UserTest::where('id', '=', Session::get('user_test'))->increment('total_correct');
	}

	public function setInCorrect() {
		return UserTest::where('id', '=', Session::get('user_test'))->increment('total_incorrect');
	}

	public static function getFinished($id) {
		return UserTest::with('test')->orderBy('created_at', 'desc')
                                                    ->where('finished', '=', '1')
                                                    ->where('user_id', '=', $id)
                                                    ->get();
	}

	public function prepareResults($id) {
		$test_id = $this->find($id)->test_id;

		$questions = Question::with(array('answers' => function($query) {

					    $query->where('r', '=', '1');

					}, 'prepared_questions' => function($query) use ($id) {

						$query->where('user_test_id', '=', $id);

					}))->where('test_id', '=', $test_id)->get();

		$this->eachResults($questions);
	}

        private function eachResults($questions) {
            /* BEST CODE EVER!!! */

            foreach ($questions as $key => $question) {
                    $this->results[$key]['id'] = $question->id;
                    $this->results[$key]['title'] = $question->title;
                    $this->results[$key]['points'] = 0;
                    foreach ($question->answers as $answer) {
                            $this->results[$key]['answers'][] = $answer->answer;
                    }
                    foreach ($question->prepared_questions as $answers) {
                            $this->results[$key]['user_answers'] = explode(',', $answers->a_indexes);
                    }
            }

            $this->countPoints();
        }

        private function countPoints() {
            foreach ($this->results as $key => $result) {
                    if(isset($result['user_answers'])) {
                            foreach ($result['user_answers'] as $u_answer) {
                                if(in_array($u_answer, $result['answers'])) {
                                        $this->results[$key]['points'] += 1;
                                }
                            }
                    }
            }
        }

        public function getPercent($id) {
		$data = $this->find($id, array('test_id', 'total_correct'));

		return round($data->total_correct * 100 / $data->test->max_points);
	}

	public function getTotalData($id) {
		$status = array(
                                '2' => 'danger',
                                '3' => 'warning',
                                '4' => 'success',
                                '5' => 'success'
                );

		$data = $this->find($id, array('test_id', 'total_correct', 'rating'));

		$percent = $this->getPercent($id);

		return array(
                            'max_points' => $data->test->max_points,
                            'points' => $data->total_correct,
                            'percent' => $percent,
                            'rating' => $data->rating,
                            'status' => $status[$data->rating]
                    );
	}

}