<?php
namespace App\Test\TestCase\Controller;

use Cake\I18n\Time;
use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;

class TotosControllerTest extends IntegrationTestCase {

/**
 * fixtures
 *
 * @var Fixture
 */
	public $fixtures = ['app.todos'];

/**
 * test add() method
 *
 * @return void
 */
	public function testAdd() {
		$this->configRequest([
			'headers' => ['Accept' => 'application/json']
		]);

		$result = $this->post(Router::url(
			['controller' => 'todos',
				'action' => 'add',
				'_ext' => 'json'
			]),
		['todo' => 'run test']);

		$this->assertResponseOk();
		$expected = [
			'response' => ['result' => 'success'],
		];
		$expected = json_encode($expected, JSON_PRETTY_PRINT);
		$this->assertEquals($expected, $this->_response->body());
	}

/**
 * test get() method
 *
 * @return void
 */
	public function testGet() {
		$this->configRequest([
			'headers' => [
				'Accept' => 'application/json'
			]
		]);

		$result = $this->post(Router::url(
			['controller' => 'todos',
				'action' => 'get',
				'_ext' => 'json'
			])
		);
		// Check that the response was a 200
		$this->assertResponseOk();

		$expected = [
			'todos' =>
				[
					[
						'id' => 1,
						'todo' => 'First To-do',
						'created' => 'on 11/21/13',
						'updated' => 'on 11/21/13',
						'is_done' => false
					],
					[
						'id' => 3,
						'todo' => 'More stuff To-do',
						'created' => 'on 11/21/13',
						'updated' => 'on 11/21/13',
						'is_done' => false
					]
				],
		];
		$expected = json_encode($expected, JSON_PRETTY_PRINT);
		$this->assertEquals($expected, $this->_response->body());

		// get completed to-do's
		$result = $this->post(Router::url(
			['controller' => 'todos',
				'action' => 'get',
				'_ext' => 'json',
				1
			])
		);
		// Check that the response was a 200
		$this->assertResponseOk();

		$expected = [
			'todos' => [
				[
					'id' => 2,
					'todo' => 'Complete To-do',
					'created' => 'on 11/21/13',
					'updated' => 'on 11/21/13',
					'is_done' => true

				]
			]
		];
		$expected = json_encode($expected, JSON_PRETTY_PRINT);
		$this->assertEquals($expected, $this->_response->body());
	}

/**
 * test fnish() method
 *
 * @return void
 */
	public function testFinish() {
		$this->configRequest([
			'headers' => [
				'Accept' => 'application/json'
			]
		]);

		$result = $this->get(Router::url(
			['controller' => 'todos',
				'action' => 'finish',
				'_ext' => 'json',
				3
			])
		);
		// Check that the response was a 200
		$this->assertResponseOk();
		$expected = [
			'response' => ['result' => 'success'],
		];
		$expected = json_encode($expected, JSON_PRETTY_PRINT);
		$this->assertEquals($expected, $this->_response->body());

		// get completed to-do's
		$result = $this->post(Router::url(
			['controller' => 'todos',
				'action' => 'get',
				'_ext' => 'json',
				1
			])
		);
		// Check that the response was a 200
		$this->assertResponseOk();

		$expected = [
			'todos' => [
				[
					'id' => 3,
					'todo' => 'More stuff To-do',
					'created' => 'on 11/21/13',
					'updated' => 'just now',
					'is_done' => true

				],
				[
					'id' => 2,
					'todo' => 'Complete To-do',
					'created' => 'on 11/21/13',
					'updated' => 'on 11/21/13',
					'is_done' => true

				],

			]
		];
		$expected = json_encode($expected, JSON_PRETTY_PRINT);

		$this->assertEquals($expected, $this->_response->body());
	}

}
