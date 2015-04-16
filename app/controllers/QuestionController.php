<?php

/**
* Questions
*/
class QuestionController extends BaseController {

	public function make($test_id) {

		if(!$test = Test::find($test_id)) {
			App::abort(404);
		}

		Session::flash('test_id', $test->id);

		return View::make('question.new');
	}

	public function create() {
		if(Request::ajax()) {

			if(empty(Input::get('r_indexes'))) {
				Session::reflash();

				return Response::json(array('response' => 'error', 'error' => array('type' => 'RIGHT_ANSWER_NOT_FOUND')));
			}

			$q = new Question;

			$q->fill(Input::all());
			$q_id = $q->make();

			$a = new Answer;
			$a->updateCorrect($q_id, Input::get('answers'), Input::get('r_indexes'));
			
			return Response::json(array('response' => 'ok'));
		}
	}

	/*
     * AJAX request, JSONresponse: id 
	 */
	public function prepare() {
		if(Request::ajax()) {

			if(!Test::isSolved(Session::get('test_id'))) {
				return Response::json(array('response' => 'error', 'msg' => 'Извините, тест еще не подготовлен.'));
			}

			$prep = new PreparedQuestion;

			$id = $prep->prepare(Session::get('test_id'));

			return Response::json(array('response' => 'ok', 'id' => $id));
		}
	}

	/*
	 * Страница с вопросом
	 */
	public function question($id) {
		if(Session::get('user_test') != $id ) {
			App::abort(404);
		}

		$prep = new PreparedQuestion;

		$current = $prep->getCurrent($id);

		if(!$current) {
			$ut = new UserTest;
			$ut->finish(Session::get('user_test'));

			return Redirect::to('u/finished');
		}

		$count = array();
		$count['all'] = $prep->getQuestionsCount($id);
		$count['current'] = $prep->getAnsweredCount($id) + 1;

		$question = Question::get($current['question_id']);
		$answers = Question::getAnswers($current['question_id']);

		Answer::shuffle($answers);
		Answer::format($answers, $question['type']);

		return View::make('question.index', array('question' => $question, 'answers' => $answers, 'count' => $count));
	}

	public function setAnswer() {
		if(empty(Input::get('a_indexes.0'))) {
			return Redirect::back()->withErrors('Вы не ответили')->withInput();
		}

		$prep = new PreparedQuestion;

		$status = $prep->setAnswer(Input::get('a_indexes'));

		if($status == true) {
			$prep->refreshCurrent(Session::get('user_test'));

			return Redirect::to('q/'.Session::get('user_test'));
		}
	}

}