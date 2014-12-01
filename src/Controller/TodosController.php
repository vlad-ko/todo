<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class TodosController extends AppController {

/**
 * initialize method
 *
 * @return void
 */
	public function initialize() {
		parent::initialize();
		$this->loadComponent('RequestHandler');
	}

/**
 * cakephp's beforeFilter()
 *
 * @param  CakeEventEvent $event cakephp event
 * @return void
 */
	public function beforeFilter(\Cake\Event\Event $event) {
		$this->RequestHandler->addInputType('json', ['json_decode', true]);
	}

/**
 * main action for the application
 * @return void
 */
	public function index()
	{
		//this method is intentionally left blank
	}

/**
 * add() action to create a new to-do
 * @return void
 */
	public function add()
	{
		$response = ['result' => 'fail'];
		$errors = $this->Todos->validator()->errors($this->request->data);
		if (empty($errors)) {
			$todo = $this->Todos->newEntity($this->request->data);
			if ($this->Todos->save($todo)) {
				$response = ['result' => 'success'];
			}
		} else {
			$response['error'] = $errors;
		}
		$this->set(compact('response'));
		$this->set('_serialize', ['response']);
	}

/**
 * gets either done or incomplete to-do's depending on the status
 *
 * @param  integer $status 0/1 incomplete/complete
 * @return void
 */
	public function get($status = 0)
	{
		$query = $this->Todos->find('recent', ['status' => $status]);
		$todos = $query->toArray();
		$this->set(compact('todos'));
		$this->set('_serialize', ['todos']);
	}

/**
 * marks the to-do as complete, i.e. changes is_done to 1
 *
 * @param  int $id id of the record to mark as done
 * @return void
 */
	public function finish($id = null)
	{
		$response = ['result' => 'fail'];
		if(!is_null($id)) {
			$todos = TableRegistry::get('Todos');
			$todo = $todos->get($id);
			$todos->patchEntity($todo, ['is_done' => 1]);
			if ($todos->save($todo)) {
				$response = ['result' => 'success'];
			}
		}
		$this->set(compact('response'));
		$this->set('_serialize', ['response']);
	}
}
