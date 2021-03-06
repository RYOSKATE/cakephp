<?php
App::uses('AppController', 'Controller');
/**
 * ModelNames Controller
 *
 * @property ModelName $ModelName
 * @property PaginatorComponent $Paginator
 */
class ModelNamesController extends AppController {

    public $uses = array('ModelName','UploadData');

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
		$this->ModelName->recursive = 0;
		$this->set('modelNames', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ModelName->exists($id)) {
			throw new NotFoundException(__('Invalid model name'));
		}
		$options = array('conditions' => array('ModelName.' . $this->ModelName->primaryKey => $id));
		$this->set('modelName', $this->ModelName->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ModelName->create();
			if ($this->ModelName->save($this->request->data)) {
				$this->flashText(__('The model name has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->flashText(__('The model name could not be saved. Please, try again.'));
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
		$this->rejectReader();
		if (!$this->ModelName->exists($id)) {
			throw new NotFoundException(__('Invalid model name'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ModelName->save($this->request->data)) {
				$this->flashText(__('The model name has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->flashText(__('The model name could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ModelName.' . $this->ModelName->primaryKey => $id));
			$this->request->data = $this->ModelName->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
 
 //そのモデル名のCSVデータが全て削除されていればモデル名も削除可能
	public function delete($id = null) {
		$this->rejectReader();
		if($this->UploadData->hasAny(array('UploadData.modelname_id'=>$id))){
			$this->flashText(__('そのモデルに依存したデータはまだ存在しています'),false);
		}else {
			$this->ModelName->id = $id;
			if (!$this->ModelName->exists()) {
				throw new NotFoundException(__('Invalid model name'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->ModelName->delete()) {
                $this->flashText(__('The model name has been deleted.'));
			} else {
				$this->flashText(__('The model name could not be deleted. Please, try again.'));
			}
		}
		return $this->redirect(array('action' => 'index'));
	}
}
