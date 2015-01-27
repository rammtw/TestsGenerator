<?php

/**
* Questions
*/
class QuestionController extends BaseController {

	public function make($test_id) {
		$test = Test::get($test_id);

		Session::flash('test_id', $test->id);

		return View::make('test.new_question', array('test' => $test));
	}

	public function create() {
		if(Request::ajax()) {
			$q = new Question;

			$test_id = Session::get('test_id');

			$q->fill(Input::all());
			$q_id = $q->make($test_id);

			foreach (Input::get('answers') as $key => $answer) {
				$a = new Answer;
				$a_id = $a->make($q_id, $answer);

				if($key+1 == Input::get('r_index')) {
					$status = Answer::setRight($a_id);
					Test::incAnswerPoints($test_id);
				}
			}
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
			$prep->setCurrent($id);

			return Response::json(array('response' => 'ok', 'id' => $id));
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