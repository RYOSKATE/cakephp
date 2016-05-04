<?php
App::uses('AppController', 'Controller');
/**
 * GroupNames Controller
 *
 * @property GroupName $GroupName
 * @property PaginatorComponent $Paginator
 */
class GroupNamesController extends AppController {
    public $uses = array('GroupName','Graph','User');

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
		$this->GroupName->recursive = 0;
		$this->set('groupNames', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->GroupName->exists($id)) {
			throw new NotFoundException(__('Invalid group name'));
		}
		$options = array('conditions' => array('GroupName.' . $this->GroupName->primaryKey => $id));
		$this->set('groupName', $this->GroupName->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->GroupName->create();
			if ($this->GroupName->save($this->request->data)) {
				$this->flashText(__('The group name has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->flashText(__('The group name could not be saved. Please, try again.'),false);
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
		
		if (!$this->GroupName->exists($id)) {
			throw new NotFoundException(__('Invalid group name'));
		}
		$message='';
		if ($this->request->is(array('post', 'put')))
		{
			try
        	{
				$preName = $this->GroupName->find('list')[$id];
				$newName = $this->request->data['GroupName']['name'];
				$merge = false;
				if($this->GroupName->hasAny(array('GroupName.name'=>$newName)))
				{
					if(isset($this->request['data']['update']))
					{
						$message = $newName.' は既に存在しています。<br>Mergeを実行することでこのグループを削除し・選択グループに統合します。';
						throw new Exception();
					}
					$merge = isset($this->request['data']['merge']);
				}
				$this->GroupName->begin();
				$dataG = $this->Graph->find('all',array('fields' => array('id','25'),'conditions' => array('Graph.25' => $preName)));
				foreach($dataG as &$value)
				{
					$value['Graph']['25']=$newName;
				}
				if (!$this->Graph->saveAll($dataG))
				{
					$message = '各データのグループ名変更に失敗しました。';
					throw new Exception();
				}
				$dataU = $this->User->find('all',array('fields' => array('id','group')));
				foreach($dataU as &$value)
				{
					$name = $value['User']['group'];
					$names = explode(',',$name);
					foreach($names as &$v)
					{
						if($v==$preName)
							$v=$newName;
					}
					$name = implode(",", $names);
					$value['User']['group']=$name;
				}
				if (!$this->User->saveAll($dataU))
				{
					$message = 'ユーザーの所属グループ名変更に失敗しました。';
					throw new Exception();
				}					
				if (!$this->GroupName->save($this->request->data))
				{
					$message = 'グループ名の変更に失敗しました。';
					throw new Exception();
				}					

				if($merge)
				{
					if(!$this->GroupName->delete(array('GroupName.id' => $id)))
					{
						$message = 'マージ処理に失敗しました。';
						throw new Exception();
					}
					else
						$message = $preName . ' を ' .$newName . ' にマージしました。';
				}
				else
					$message = $preName . ' を ' .$newName . ' に変更しました。';

				$this->GroupName->commit();
				$this->flashText($message);
				return $this->redirect(array('action' => 'index'));
			}
			catch(Exception $e) 
			{
				$this->flashText($message,false);
				$this->GroupName->rollback();
				return null;
			}
		} else {
			$options = array('conditions' => array('GroupName.' . $this->GroupName->primaryKey => $id));
			$this->request->data = $this->GroupName->find('first', $options);
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
		$this->GroupName->id = $id;
		$name = $this->GroupName->find('list')[$id];
		if($this->Graph->hasAny(array('Graph.25'=>$name))){
			$this->Session->setFlash(__($name.'に依存したデータはまだ存在しています。<重複したグループ名が存在する場合は削除可能です。><button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
		}else {
			if (!$this->GroupName->exists()) {
				throw new NotFoundException(__('Invalid group name'));
			}
			$this->request->allowMethod('post', 'delete');
			if ($this->GroupName->delete()) {
				$this->flashText(__($name.' を削除しました。'));
			} else {
				$this->flashText(__($name.' を削除できませんでした。'),false);
			}
		}
		return $this->redirect(array('action' => 'index'));
	}
}
