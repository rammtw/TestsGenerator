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
			App::Abort(404);
		}

		$question = Question::get($current['question_id']);
		$answers = Question::getAnswers($current['question_id']);

		$answers = Answer::shuffle($answers);

		Answer::format($answers, $question['type']);

		return View::make('test.question', array('question' => $question, 'answers' => $answers));
	}

	public function setAnswer() {
		$status = PreparedQuestion::setAnswer(Input::get('answer'));

		if($status == true) {
			PreparedQuestion::setCurrent(Session::get('user_test_id'));

			return Redirect::to('q/'.Session::get('user_test_id'));
		}
	}

}