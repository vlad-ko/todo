<?php
namespace App\Test\TestCase\Model\Table;

use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

class TodosTest extends TestCase {

/**
 * fixtures
 *
 * @var array
 */
	public $fixtures = ['app.todos'];

/**
 * setUp() method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Todos = TableRegistry::get('Todos');
	}

/**
 * test saving of a to-do, validation
 *
 * @return void
 */
	public function testSaving() {
		$data = ['todo' => ''];
		$todo = $this->Todos->newEntity($data);
		$resultingError = $this->Todos->validator()->errors($data);
		$expectedError = [
			'todo' => [
				'This field cannot be left empty'
			]
		];
		$this->assertEquals($expectedError, $resultingError);

		$total = $this->Todos->find()->count();
		$this->assertEquals(3, $total);

		$data = ['todo' => 'testing'];
		$todo = $this->Todos->newEntity($data);
		$this->Todos->save($todo);
		$newTotal = $this->Todos->find()->count();
		$this->assertEquals(4, $newTotal);
	}

/**
 * test custom finder method
 *
 * @return void
 */
	public function testRecent() {
		$result = $this->Todos->find('recent', ['status' => 0]);
		$recent = $result->first()->toArray();
		$expected = [
				'id' => 1,
				'todo' => 'First To-do',
				'created' => 'on 11/21/13',
				'updated' => 'on 11/21/13',
				'is_done' => false
		];

		$this->assertEquals($expected, $recent);
	}

/**
 * test saving of a to-do with evil data
 *
 * @return void
 */
	public function testSaveEvilScript() {
		$data = ['todo' => '<script>alert("hi")</script>', 'is_done' => 1];
		$todo = $this->Todos->newEntity($data);
		$this->Todos->save($todo);
		$newTotal = $this->Todos->find()->count();
		$this->assertEquals(4, $newTotal);

		$result = $this->Todos->find('recent', ['status' => 1])->where(['id' => 4])->first();
		$this->assertEquals('&lt;script&gt;alert(&quot;hi&quot;)&lt;/script&gt;', $result->todo);
	}

/**
 * test to make sure custom finder returns the dates in a human-readable format
 *
 * @return void
 */
	public function testFindTimeAgoInWords() {
		$todos = TableRegistry::get('Todos');
		$todo = $todos->get(1);
		$todos->patchEntity($todo, ['updated' => new Time(date('Y-m-d H:i:s', strtotime('-3 seconds ago')))]);
		$todos->save($todo);
		$result = $todos->find('recent', ['status' => 0])->where(['id' => 1])->first();
		$this->assertContains('second', $result->updated);

		$todos = TableRegistry::get('Todos');
		$todo = $todos->get(1);
		$todos->patchEntity($todo, ['created' => new Time(date('Y-m-d H:i:s', strtotime('-3 seconds ago')))]);
		$todos->save($todo);
		$result = $todos->find('recent', ['status' => 0])->where(['id' => 1])->first();
		$this->assertContains('second', $result->created);
	}
}
