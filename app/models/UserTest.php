<?php

class UserTest extends Eloquent {

	public $table = 'user_tests';

	private static $criteria = array(2 => array(0, 49),
								     3 => array(50, 69),
								     4 => array(70, 89),
								     5 => array(90, 100)
								);

	public static function make($test_id) {
		$id = UserTest::insert(array('user_id' => Auth::user()->id,
									'test_id' => $test_id,
								));

		return $id;
	}

	public static function getByHash($hash) {
		$test_id = UserTest::where('user_id', '=', Auth::user()->id)
								->where('hash', '=', $hash)
								->pluck('test_id');

		return $test_id;
	}

	public static function updateUserRating($id, $rating) {
		return UserTest::where('user_id', '=', Auth::user()->id)->where('id', '=', $id)->update(array('rating' => $rating));
	}

    public static function countUserRating($id) {
    	$points = UserTest::where('id', '=', $id)->get(array('test_id', 'total_correct'))->toArray();

    	$test = Test::get($points[0]['test_id']);

    	$correct = $points[0]['total_correct'];

    	$c_per = floor($correct * 100 / $test['questions_count']);

    	foreach (self::$criteria as $r => $range) {
    		foreach ($range as $i => $value) {
    			if ($i === 0 && $c_per >= $value && $c_per <= $range[$i + 1])
    				$rating = $r;
    		}
    	}

    	return self::updateUserRating($id, $rating);
	}

	public function countTotalInTest() {

	}

}