<?php

class ExampleTest extends TestCase {

	public function testCreateTest() {

		$this->be(User::find(46));

		$parameters = array(
							'action' => 'create',
							'name' => 'Random_test',
							'subject_id' => 5,
							'csrf_token' => csrf_token()
					);

		$response = $this->call('POST', 'test/do', $parameters);

		$this->assertRedirectedTo('test/my');
		$this->assertSessionHas('message');
	}

	public function createQuestion($parameters) {
		$this->session(['test_id' => '20']);

		$this->client->setServerParameter('HTTP_X-Requested-With', 'XMLHttpRequest');

		$response = $this->call('POST', 'test/q/create', $parameters);

        $this->assertResponseOk();

    	$this->client->getResponse()->isOk();
	}


	public function testCreateQuestionRadio() {

		$parameters = array(
					'title' => 'Random_radio_question',
					'type' => 'radio',
					'r_indexes' => array('1'),
					'answers' => array('first',
										'sec',
										'third',
										'forth'
								),
					'csrf_token' => csrf_token()
			);


		$this->createQuestion($parameters);

	}

	public function testCreateQuestionCheckbox() {

		$parameters = array(
					'title' => 'Random_checkbox_question',
					'type' => 'checkbox',
					'r_indexes' => array(
										'3',
										'1',
										'2'
								),
					'answers' => array('first',
										'sec',
										'third',
										'forth'
								),
					'csrf_token' => csrf_token()
			);

		$this->createQuestion($parameters);

	}

	public function testCreateQuestionInput() {

		$parameters = array(
					'title' => 'Random_input_question',
					'type' => 'input',
					'r_indexes' => array('0'),
					'answers' => array('Random_answer_input'),
					'csrf_token' => csrf_token()
			);

		$this->createQuestion($parameters);

	}

}
