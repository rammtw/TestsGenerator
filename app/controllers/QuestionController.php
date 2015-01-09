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
			$hash = Question::prepare(Input::get('test_id'));

			return Response::json(array('hash' => $hash));
		}
	}

	/*
	 * Страница с вопросом
	 */
	public function question($hash) {
		$question = Question::getByHash($hash);

		$answers = Question::shuffle_answers($question->answers);

		Session::put('c', $hash);

		return View::make('test.question', array('question' => $question, 'answers' => $answers));
	}

	public function setAnswer() {
		if(Request::ajax()) {
			$answers = rtrim(Input::get('a'), "|");

			Question::setAnswer($answers, Input::get('c'));

			$this->prepare();
		}
	}

}