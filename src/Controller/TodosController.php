<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class TodosController extends AppController {
	public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(\Cake\Event\Event $event) {
    	$this->RequestHandler->addInputType('json', ['json_decode', true]);
    }

	public function index()
	{

	}

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

	public function get($status = 0)
	{
		$query = $this->Todos->find('recent', ['status' => $status]);
		$todos = $query->toArray();
		$this->set(compact('todos'));
    	$this->set('_serialize', ['todos']);
	}

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