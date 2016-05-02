<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {
	
    public $layout = "for_user";//for_user.ctpのレイアウト設定を読み込む

    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout');
        if($this->User->IsRegisteredNoUser())
        {
            $this->set('enableAdd', true);
        }
    }
    	
    public function flashText($message,$isSuccess=true)
    {
        if($isSuccess)
            $this->Session->setFlash(__($message.'<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
        else
            $this->Session->setFlash(__($message.'<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
    }
    
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	
    public function manage() 
    {
    }
/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->rejectWithoutAdmin();
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
        $this->rejectWithoutAdmin();
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

    public function add()
    {
        $groupNameData = $this->setGroupNameWithAll('add');
        if ($this->request->is('post')) 
        {
            if($this->User->addUser($this->request->data['User'],$groupNameData))
            {
                $this->flashText('The user has been saved.');
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->flashText('The user could not be saved. Please, try again.',false);
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
        $this->rejectWithoutAdmin();
        $groupNameData = $this->setGroupNameWithAll('add');
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}

		if ($this->request->is(array('post', 'put'))) {
            foreach ($this->request->data['User']['group'] as &$value)
            {
                $value = $groupNameData[$value];
            }
            $this->request->data['User']['group'] = implode(",",$this->request->data['User']['group']);
			if ($this->User->save($this->request->data)) {
                $this->flashText('The user has been saved.');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->flashText('The user could not be saved. Please, try again.',false);
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

	public function ownEdit($id = null) 
    {
        $id = $this->Auth->user('id');
        $this->User->id = $id;
        if (!$this->User->exists($id)) 
        {
            throw new NotFoundException(__('Invalid customer'));
        }

        if ($this->request->is('post') || $this->request->is('put'))
        {
 
            //パスワードがある場合のみパスワードをDBでUpdate
            if (!empty($this->request->data['User']['new password'])) 
            {
                $this->request->data['User']['password'] = $this->request->data['User']['new password'];                
            }
 
            if ($this->User->save($this->request->data))
            {
                $this->flashText('パスワードを変更しました');
            }
            else 
            {
                $this->flashText('パスワードの変更に失敗しました',false); 
            }
        }
        else
        {   
             $this->request->data = $this->User->read(null, $id);
             unset($this->request->data['User']['password']);
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
        $this->rejectWithoutAdmin();
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
            $this->flashText('The user has been deleted.');
		} else {
            $this->flashText('The user could not be deleted. Please, try again.',false);
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function ownDelete($id = null) 
    {
        if ($this->request->is('post'))
        {
            $message = 'Invalid username or password, try again.';
            $username = $this->request['data']['User']['username'];
            $password = $this->request['data']['User']['password'];
			
			$role = $this->Auth->user('role');
			$numOfAdmin = count($this->User->find('all', array("roll" => "admin")));
			$message == "あなたは最後のadminユーザーです";
			if($role !="admin" && 1<$numOfAdmin)
			{
				$message == "ユーザーネームとパスワードを確認してください";
				if($username == $this->Auth->user('username'))
				{
					$message == "このユーザーは既に存在しません";
					$id = $this->Auth->user('id');
					if ($this->User->exists($id)) 
					{
						if ($this->User->delete($id)) 
						{
                            $this->flashText('user deleted');
							$this->redirect(array('action' => 'login'));
						}
					}
				}
			}
            $this->flashText($message,false);
        }
    }
    public function login()
    {
        if ($this->request->is('post'))
        {
            if ($this->Auth->login()) 
            {
                $this->redirect($this->Auth->redirect());
            } 
            else 
            {
                $this->Session->setFlash('Invalid username or password, try again.<button class="close" data-dismiss="alert">&times;</button>', 'default', ['class'=> 'alert alert-warning alert-dismissable']);
            }
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }
}
