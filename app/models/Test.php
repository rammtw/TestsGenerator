<?php

class Test extends Eloquent {

	public $timestamps = false;

    public static $validation = array(
        'name'  => 'required',

        'subject_id'  => 'required|numeric'
    );

	protected $fillable = array('id', 'name', 'user_id', 'subject_id', 'questions_count', 'created_date');

	public function subject() {
		return $this->belongsTo('Subject');
	}

	public function questions() {
		return $this->hasMany('Question');
	}

	public function answers() {
		return $this->hasManyThrough('Answer', 'Question');
	}

	public function make() {
		$this->user_id = Auth::user()->id;

		$this->created_date = date('Y-m-d H:i:s');

		$this->save();
	}

	public static function isSolved($id) {
		$questions_count = self::where('id', '=', $id)->pluck('questions_count');

		if($questions_count > 0) {
			return true;
		}
		return false;
	}

	public function updateData() {
		$row = Test::where('id', '=', $this->id)->update(array('name' => $this->name, 'subject_id' => $this->subject_id));
	}

	public function delete() {
		$row = Test::where('id', '=', $this->id)->delete();
	}

	public static function incQuestionCount($id) {
		return self::where('id', '=', $id)->increment('questions_count');
	}

	public static function incAnswerPoints($id) {
		return self::where('id', '=', $id)->increment('max_points');
	}
}