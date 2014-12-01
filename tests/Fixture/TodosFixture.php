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
			'created' => '2014-11-21 12:00:00',
			'updated' => '2014-11-21 12:00:00'
		]
	];
}
