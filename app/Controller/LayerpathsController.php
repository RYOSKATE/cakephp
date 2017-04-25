<?php
App::uses('AppController', 'Controller');
/**
 * Layerpaths Controller
 *
 * @property Layerpath $Layerpath
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class LayerpathsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Layerpath->recursive = 0;
		$this->set('layerpaths', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Layerpath->exists($id)) {
			throw new NotFoundException(__('Invalid layerpath'));
		}
		$options = array('conditions' => array('Layerpath.' . $this->Layerpath->primaryKey => $id));
		$this->set('layerpath', $this->Layerpath->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Layerpath->create();
			if ($this->Layerpath->save($this->request->data)) {
				$this->Session->setFlash(__('The layerpath has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The layerpath could not be saved. Please, try again.'));
			}
		}
		$layers = $this->Layerpath->Layer->find('list');
		$this->set(compact('layers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Layerpath->exists($id)) {
			throw new NotFoundException(__('Invalid layerpath'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Layerpath->save($this->request->data)) {
				$this->Session->setFlash(__('The layerpath has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The layerpath could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Layerpath.' . $this->Layerpath->primaryKey => $id));
			$this->request->data = $this->Layerpath->find('first', $options);
		}
		$layers = $this->Layerpath->Layer->find('list');
		$this->set(compact('layers'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Layerpath->id = $id;
		if (!$this->Layerpath->exists()) {
			throw new NotFoundException(__('Invalid layerpath'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Layerpath->delete()) {
			$this->Session->setFlash(__('The layerpath has been deleted.'));
		} else {
			$this->Session->setFlash(__('The layerpath could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
