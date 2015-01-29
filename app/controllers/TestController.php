<?php

class TestController extends BaseController {

	/* 
     * Страница информации
	 */
	public function info($test_id) {
		$test = Test::get($test_id);

		if(!$test){
			App::abort(404);
		}

		Session::flash('test_id', $test->id);

		return View::make('test.info', array('test' => $test));
	}

	public function build() {
		$subjects = Subject::getList();

		return View::make('test.new', array('subjects' => $subjects));
	}

	public function my() {
		$tests = Test::getAll();

		return View::make('test.my', array('tests' => $tests));
	}

	public function doAction() {
		$data = Input::all();

		if(Input::has('action')){
			switch (Input::get('action')) {
				case 'create':
					return $this->create($data);
					break;
				case 'update':
					return $this->update($data);
					break;
				case 'delete':
					return $this->delete($data);
					break;
			}	
		}

	}

	public function create($data) {
		$rules = Test::$validation;

		$validation = Validator::make($data, $rules);

		if($validation->fails()) {
			return Redirect::back()->withErrors($validation)->withInput();
		}

		$test = new Test;
		$test->fill($data);
		$test->make();

		return Redirect::to('test/my')->with('message', 'Тест успешно создан!');
	}

	public function edit($id) {
		$test = Test::get($id);
		$subjects = Subject::getList();

		return View::make('test.edit', array('test' => $test, 'subjects' => $subjects));
	}

	public function update($data) {
		$rules = Test::$validation;

		$validation = Validator::make($data, $rules);

		if($validation->fails()) {
			return Redirect::back()->withErrors($validation)->withInput();
		}

		$test = new Test;
		$test->fill($data);
		$test->updateData();

		return Redirect::to('test/my')->with('message', 'Сохранено!');
	}

	public function delete($data) {
		$test = new Test;
		$test->fill($data);
		$test->delete();

		return Redirect::to('test/my')->with('message', 'Тест успешно удален!');
	}

	public function createSubject() {
		$subject = new Subject;
		$subject->fill(Input::all());
		$subject->make();

		return Redirect::to('test/subject/new')->with('message', 'Сохранено!');
	}

	public function allSubjects() {
		$subjects = Subject::all();

		return View::make('subject.all', array('subjects' => $subjects));
	}

}