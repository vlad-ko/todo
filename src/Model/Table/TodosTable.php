<?php
namespace App\Model\Table;

use Cake\I18n\Time;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TodosTable extends Table {

/**
 * initialize method
 *
 * @param array $config list of config options
 * @return void
 */
	public function initialize(array $config) {
		$this->addBehavior('Timestamp', [
			'events' => [
				'Model.beforeSave' => [
				'created' => 'new',
				'updated' => 'always'
			]
		]]);
	}

/**
 * Default validator method
 *
 * @param Validator $validator cakephp validator object
 * @return Validator $validator cakephp validator object
 */
	public function validationDefault(Validator $validator) {
		$validator
		->allowEmpty('todo', 'update')
		->notEmpty('todo');

		return $validator;
	}

/**
 * Custom finder method, returns recent to-do's based on status
 *
 * @param Query $query  cakephp query object
 * @param array $options list of options
 * @return query $query cakephp query object
 */
	public function findRecent(Query $query, array $options = ['status' => 0]) {
		return $query
				->where(['is_done' => $options['status']])
				->order(['updated' => 'DESC'])
				->formatResults(function ($results, $query) {
					return $results->map(function ($row) {
						$timeCreated = new Time($row->created);
						$timeUpdated = new Time($row->updated);

						$row->created = $timeCreated->timeAgoInWords();
						$row->updated = $timeUpdated->timeAgoInWords();
						$row->todo = htmlspecialchars($row->todo);

						return $row;
					});
				});
	}
}
