<?php
namespace App\Test\TestCase\Model\Table;

use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\ORM\Query;

class TodosTest extends TestCase {

/**
 * fixtures
 *
 * @var array
 */
	public $fixtures = ['app.todos'];

/**
 * instance of Todos table obj
 *
 * @var object
 */
	protected $Todos;

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
		$this->assertEquals(1, $total);

		$data = ['todo' => 'testing'];
		$todo = $this->Todos->newEntity($data);
		$this->Todos->save($todo);
		$newTotal = $this->Todos->find()->count();
		$this->assertEquals(2, $newTotal);
	}

/**
 * test cutom finder method
 *
 * @return void
 */
	public function testRecent() {
		$result = $this->Todos->find('recent', ['status' => 0]);
		$recent = $result->first()->toArray();
		$expected = [
				'id' => 1,
				'todo' => 'First To-do',
				'created' => '1 week, 3 days ago',
				'updated' => '1 week, 3 days ago',
				'is_done' => 0
		];

		$this->assertEquals($expected, $recent);
	}

/**
 * test to make sure customer finder return the dates in a human-readable format
 *
 * @return void
 */
	public function testFindTimeAgoInWords() {
		$todos = TableRegistry::get('Todos');
		$todo = $todos->get(1);
		$todos->patchEntity($todo, ['updated' => new Time(date('Y-m-d H:i:s', strtotime('-3 seconds ago')))]);
		$todos->save($todo);
		$result = $todos->find('recent', ['status' => 0]);
		$r = $result->toArray();
		$this->assertContains('second', $r[0]->updated);

		$todos = TableRegistry::get('Todos');
		$todo = $todos->get(1);
		$todos->patchEntity($todo, ['created' => new Time(date('Y-m-d H:i:s', strtotime('-3 seconds ago')))]);
		$todos->save($todo);
		$result = $todos->find('recent', ['status' => 0]);
		$r = $result->toArray();
		$this->assertContains('second', $r[0]->created);
	}
}
