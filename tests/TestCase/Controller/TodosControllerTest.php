<?php
namespace App\Test\TestCase\Controller;

use Cake\Routing\Router;
use Cake\TestSuite\IntegrationTestCase;
use Cake\I18n\Time;

class TotosControllerTest extends IntegrationTestCase {
	public $fixtures = ['app.todos'];

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

        // Check that the response was a 200
        $this->assertResponseOk();

        $expected = [
            'response' => ['result' => 'success'],
        ];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        $this->assertEquals($expected, $this->_response->body());
     }

     public function testGet() {
     	$this->configRequest([
            'headers' => [
            	'Accept' => 'application/json'
        	]
        ]);

        $result = $this->get(Router::url(
        	['controller' => 'todos',
        	 'action' => 'get',
        	 '_ext' => 'json'
			])
		);
		// Check that the response was a 200
        $this->assertResponseOk();

        $expected = [
            [
                'id' => 1,
                'todo' => 'First To-do',
                'created' => new Time('2014-11-21 12:00:00'),
                'updated' => new Time('2014-11-21 12:00:00'),
                'is_done' => false
            ]
        ];
        $this->assertEquals($expected, $result);
     }

     public function testFinish() {
     	$this->configRequest([
            'headers' => [
            	'Accept' => 'application/json'
        	]
        ]);

        $result = $this->get(Router::url(
        	['controller' => 'todos',
        	 'action' => 'finish',
        	 '_ext' => 'json'
			], ['id' => 1])
		);

		// Check that the response was a 200
        $this->assertResponseOk();

        $data = $result = $this->get(Router::url(
        	['controller' => 'todos',
        	 'action' => 'get',
        	 '_ext' => 'json'
			], ['status' => 1])
		);
		$expected = [];
        $this->assertEquals($expected, $data);
       }

}
