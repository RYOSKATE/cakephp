<?php
App::uses('AppController', 'Controller');
/**
 * Metricslists Controller
 *
 * @property Metricslist $Metricslist
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class MetricslistsController extends AppController {

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
		$this->Metricslist->recursive = 0;
		$this->set('metricslists', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Metricslist->exists($id)) {
			throw new NotFoundException(__('Invalid metricslist'));
		}
		$options = array('conditions' => array('Metricslist.' . $this->Metricslist->primaryKey => $id));
		$this->set('metricslist', $this->Metricslist->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Metricslist->create();
			if ($this->Metricslist->save($this->request->data)) {
				$this->Session->setFlash(__('The metricslist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The metricslist could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Metricslist->exists($id)) {
			throw new NotFoundException(__('Invalid metricslist'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Metricslist->save($this->request->data)) {
				$this->Session->setFlash(__('The metricslist has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The metricslist could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Metricslist.' . $this->Metricslist->primaryKey => $id));
			$this->request->data = $this->Metricslist->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Metricslist->id = $id;
		if (!$this->Metricslist->exists()) {
			throw new NotFoundException(__('Invalid metricslist'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Metricslist->delete()) {
			$this->Session->setFlash(__('The metricslist has been deleted.'));
		} else {
			$this->Session->setFlash(__('The metricslist could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
