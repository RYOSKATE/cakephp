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
                $this->flashText(__('The user has been saved.'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->flashText(__('The user could not be saved. Please, try again.'),false);
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
                $this->flashText(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->flashText(__('The user could not be saved. Please, try again.'),false);
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
                $this->flashText(__('パスワードを変更しました'));
            }
            else 
            {
                $this->flashText(__('パスワードの変更に失敗しました'),false); 
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
            $this->flashText(__('The user has been deleted.'));
		} else {
            $this->flashText(__('The user could not be deleted. Please, try again.'),false);
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function ownDelete($id = null) 
    {
        if ($this->request->is('post'))
        {
            //正しいログインデータを保持。
            //一度ログアウトし、入力情報でログインできれば正しい名前とパスワードとして削除実行
            //ログインできなければエラー出力と保持しているデータでログイン状態に。
            $data = array(
            'id' => $this->Auth->user('id'),
            'username' => $this->Auth->user('username'),
            'password' => $this->Auth->user('password'),
			'role' => $this->Auth->user('role'),
            );
            
            $this->Auth->logout();
            //$login['username'] = $this->request['data']['User']['username'];
            //$login['password'] = $this->Auth->password($this->request['data']['User']['password']);
            $numOfAdmin = count($this->User->find('all', array("roll" => "admin")));
			$message = "あなたは最後のadminユーザーです";
			if($data['role'] !="admin" || 1!=$numOfAdmin)
			{
				$message = "ユーザーネームとパスワードを確認してください";
				if($this->Auth->login())
				{
                    if ($this->User->delete($data['id'])) 
                    {
                        $this->flashText(__('user deleted'));
                        $this->redirect(array('action' => 'login'));
                    }
				}
			}
            $this->Auth->login($data);
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
                $message = __('Invalid username or password, try again.');
                $this->Session->setFlash($message . '<button class="close" data-dismiss="alert">&times;</button>', 'default', ['class'=> 'alert alert-warning alert-dismissable']);
            }
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }
}
