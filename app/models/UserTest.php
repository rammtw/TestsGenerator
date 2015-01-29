<?php

class UserTest extends Eloquent {

	public $table = 'user_tests';

	private static $criteria = array(2 => array(0, 49),
								     3 => array(50, 69),
								     4 => array(70, 89),
								     5 => array(90, 100)
								);

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

		Session::forget('cur_test');
		Session::forget('cur_prepared');

		return UserTest::where('id', '=', $id)
							->update(array('finished' => 1));
	}

	public static function updateUserRating($id, $rating) {
		return UserTest::where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->update(array('rating' => $rating));
	}

    public function countUserRating($id) {
    	$points = UserTest::where('id', '=', $id)->get(array('test_id', 'total_correct'))->toArray();

    	$test = Test::get($points[0]['test_id']);

    	$correct = $points[0]['total_correct'];

    	$c_per = round($correct * 100 / $test['max_points']);

    	foreach (self::$criteria as $r => $range) {
    		foreach ($range as $i => $value) {
    			if ($i === 0 && $c_per >= $value && $c_per <= $range[$i + 1])
    				$rating = $r;
    		}
    	}

    	return self::updateUserRating($id, $rating);
	}

	public function countTotalInTest($id) {
		$prep = new PreparedQuestion;

		$answered = $prep->getAnswered($id);

		foreach ($answered as $key => $answer) {
			$a[$key] = explode(',', $answer);
		}

		foreach ($a as $key => $value) {
			foreach ($value as $key2 => $value2) {
				$r = Answer::where('question_id', '=', $key)
								->where('id', '=', $value2)
								->orWhere('answer', '=', $value2)
								->pluck('r');
				if($r == true)
					$this->setCorrect();
				else
					$this->setInCorrect();
			}
		}
	}

	public function setCorrect() {
		return UserTest::where('id', '=', Session::get('cur_test'))->increment('total_correct');
	}

	public function setInCorrect() {
		return UserTest::where('id', '=', Session::get('cur_test'))->increment('total_incorrect');
	}

	public static function getFinished($id) {
		return UserTest::orderBy('user_tests.created_at', 'desc')
									->where('user_tests.user_id', '=', $id)
									->get();
	}

}