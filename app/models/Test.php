<?php

class Test extends Eloquent {

	public $timestamps = false;

    public static $validation = array(
        'name'  => 'required',

        'subject_id'  => 'required|numeric'
    );

	protected $fillable = array('id', 'name', 'user_id', 'subject_id', 'questions_count', 'created_date');

	public function make() {
		$this->user_id = Auth::user()->id;

		$this->created_date = date('Y-m-d H:i:s');

		$this->save();
	}

	public static function get($test_id) {
		$test = Test::find($test_id);

		return $test;
	}

	public static function isSolved($id) {
		$test = self::get($id);

		if($test['questions_count'] > 0) {
			return true;
		}
		return false;
	}

	public static function getAll() {
		$tests = DB::table('tests')
					->orderBy('created_date', 'DESC')
		            ->where('tests.user_id', '=', Auth::user()->id)
		            ->join('subjects', 'subjects.id', '=', 'tests.subject_id')
		            ->select('tests.id', 'tests.name', 'subjects.name as subject', 'tests.questions_count', 'tests.created_date')->get();

        return $tests;
	}

	public function updateData() {
		$row = Test::where('id', '=', $this->id)->update(array('name' => $this->name, 'subject_id' => $this->subject_id));
	}

	public function delete() {
		$row = Test::where('id', '=', $this->id)->delete();
	}

	public static function getSubjects() {
		$subjects = DB::table('subjects')->lists('name','id');

		return $subjects;
	}

	public function createSubject() {
		DB::table('subjects')
            ->insert(array('name' => $this->name));
	}

	public static function incQuestionCount($id) {
		return self::where('id', '=', $id)->increment('questions_count');
	}

	public static function incAnswerPoints($id) {
		return self::where('id', '=', $id)->increment('max_points');
	}
}