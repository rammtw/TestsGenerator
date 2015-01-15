<?php

/**
* Questions
*/
class QuestionController extends BaseController {

	/*
     * AJAX request, JSONresponse: hash 
	 */
	public function prepare() {
		if(Request::ajax()) {
			$hash = PreparedQuestion::prepare(Input::get('test_id'));

			return Response::json(array('hash' => $hash));
		}
	}

	/*
	 * Страница с вопросом
	 */
	public function question($hash) {
		$question = Question::getByHash($hash);

		$answers = PreparedQuestion::shuffleAnswers($question->answers);

		Session::put('hash', $hash);

		return View::make('test.question', array('question' => $question, 'answers' => $answers));
	}

	public function setAnswer() {
		if(Request::ajax()) {
			$answers = rtrim(Input::get('a'), "|");

			$status = PreparedQuestion::setAnswer($answers, Input::get('c'));

			if($status == true)
				$hash = PreparedQuestion::prepare(Input::get('test_id'));

		}
	}

}