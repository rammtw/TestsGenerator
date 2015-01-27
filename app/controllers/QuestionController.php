<?php

/**
* Questions
*/
class QuestionController extends BaseController {

	public function make($test_id) {
		$test = Test::get($test_id);

		return View::make('test.new_question', array('test' => $test));
	}

	public function create() {
		var_dump(Input::all());
	}

	/*
     * AJAX request, JSONresponse: hash 
	 */
	public function prepare() {
		if(Request::ajax()) {

			$prep = new PreparedQuestion;

			$id = $prep->prepare(Input::get('test_id'));
			$prep->setCurrent($id);

			return Response::json(array('id' => $id));
		}
	}

	/*
	 * Страница с вопросом
	 */
	public function question($id) {
		$prep = new PreparedQuestion;

		$current = $prep->getCurrent($id);

		if(!$current) {
			$ut = new UserTest;
			$ut->finish(Session::get('cur_test'));

			return Redirect::to('u/passed');
		}

		$question = Question::get($current['question_id']);
		$answers = Question::getAnswers($current['question_id']);

		Answer::shuffle($answers);
		Answer::format($answers, $question['type']);

		return View::make('test.question', array('question' => $question, 'answers' => $answers));
	}

	public function setAnswer() {
		if(empty(Input::get('a_indexes.0'))) {
			return Redirect::back()->withErrors('Вы не ответили')->withInput();
		}

		$prep = new PreparedQuestion;

		$status = $prep->setAnswer(Input::get('a_indexes'));

		if($status == true) {
			$prep->refreshCurrent(Session::get('cur_test'));

			return Redirect::to('q/'.Session::get('cur_test'));
		}
	}

}