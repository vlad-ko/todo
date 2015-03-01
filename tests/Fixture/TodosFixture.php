<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

class TodosFixture extends TestFixture {

	public $import = ['table' => 'todos'];

	public $records = [
		[
			'id' => 1,
			'todo' => 'First To-do',
			'is_done' => '0',
			'created' => '2013-11-21 12:00:00',
			'updated' => '2013-11-21 12:00:00'
		],
		[
			'id' => 2,
			'todo' => 'Complete To-do',
			'is_done' => '1',
			'created' => '2013-11-21 12:00:00',
			'updated' => '2013-11-21 12:00:00'
		]
	];
}
