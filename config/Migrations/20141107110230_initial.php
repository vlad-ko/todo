<?php

use Phinx\Migration\AbstractMigration;

class Initial extends AbstractMigration {

/**
 * Change Method.
 *
 * More information on this method is available here:
 * http://docs.phinx.org/en/latest/migrations.html#the-change-method
 *
 * Uncomment this method if you would like to use it.
 *
 * @return void
 **/
	public function change() {
		// create the table
		$table = $this->table('todos');
		$table->addColumn('todo', 'string', ['limit' => 200])
				->addColumn('created', 'datetime')
				->addColumn('updated', 'datetime')
				->addColumn('is_done', 'boolean')
				->create();
	}
}
