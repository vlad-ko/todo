<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\I18n\Time;

class TodosTable extends Table {

	public function initialize(array $config) {
		$this->addBehavior('Timestamp' , [
			'events' => [
				'Model.beforeSave' => [
				'created' => 'new',
				'updated' => 'always'
			]
		]]);
	}

	public function validationDefault(Validator $validator) {
		$validator
		->allowEmpty('todo', 'update')
		->notEmpty('todo');

		return $validator;
	}

	public function findRecent(Query $query, array $options) {
		if (empty($options)) {
			$options['status'] = 0;
		}
		$query = $this->find()
				->where(['is_done' => $options['status']])
				->order(['updated' => 'DESC'])
				->map(function ($row) {
					$timeCreated = new Time($row->created);
					$timeUpdated = new Time($row->updated);

					$row->created = $timeCreated->timeAgoInWords();
					$row->updated = $timeUpdated->timeAgoInWords();
				return $row;
			});
		//debug($query);
		return $query;
	}
}
