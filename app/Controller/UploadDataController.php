<?php
App::uses('AppController', 'Controller');
/**
 * UploadData Controller
 *
 * @property UploadData $UploadData
 * @property PaginatorComponent $Paginator
 */
class UploadDataController extends AppController {
	
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->UploadData->recursive = 0;
		$data = $this->Paginator->paginate();
		$this->set('uploadData', $data);
		return $data;
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->rejectReader();
		if (!$this->UploadData->exists($id)) {
			throw new NotFoundException(__('Invalid upload data'));
		}
		$options = array('conditions' => array('UploadData.' . $this->UploadData->primaryKey => $id));
		$this->set('uploadData', $this->UploadData->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	// public function add() {
	// 	$this->rejectNotAdmin();
	// 	if ($this->request->is('post')) {
	// 		$this->UploadData->create();
	// 		if ($this->UploadData->save($this->request->data)) {
				
	// 			$this->flashText(__('The upload data has been saved.'));
	// 			return $this->redirect(array('action' => 'index'));
	// 		} else {
	// 			$this->flashText(__('The upload data could not be saved. Please, try again.'),false);
	// 		}
	// 	}
	// 	$modelnames = $this->UploadData->Modelname->find('list');
	// 	$users = $this->UploadData->User->find('list');
	// 	$this->set(compact('modelnames', 'users'));
	// }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	// public function edit($id = null) {		
	// 	$this->rejectReader();
	// 	if (!$this->UploadData->exists($id)) {
	// 		throw new NotFoundException(__('Invalid upload data'));
	// 	}
	// 	if ($this->request->is(array('post', 'put'))) {
	// 		if ($this->UploadData->save($this->request->data)) {
	// 			$this->flashText(__('The upload data has been saved.'));
	// 			return $this->redirect(array('action' => 'index'));
	// 		} else {
	// 			$this->flashText(__('The upload data could not be saved. Please, try again.'),false);
	// 		}
	// 	} else {
	// 		$options = array('conditions' => array('UploadData.' . $this->UploadData->primaryKey => $id));
	// 		$this->request->data = $this->UploadData->find('first', $options);
	// 	}
	// 	$modelnames = $this->UploadData->Modelname->find('list');
	// 	$users = $this->UploadData->User->find('list');
	// 	$this->set(compact('modelnames', 'users'));
	// }

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->UploadData->id = $id;
			if (!$this->UploadData->exists()) {
				throw new NotFoundException(__('Invalid upload data'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->UploadData->delete()) {
				$this->loadModel('Graph');
				if ($this->Graph->deleteAll(array('upload_data_id' => $id))) {
					$this->flashText(__('The upload data has been deleted.'));
				}
			} else {
				$this->flashText(__('The upload data could not be deleted. Please, try again.'),false);
			}
		return $this->redirect(array('action' => 'index'));
	}
}
