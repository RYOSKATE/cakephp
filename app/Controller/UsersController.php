<?php

// app/Controller/UsersController.php
class UsersController extends AppController 
{
    public $layout = "for_user";//for_user.ctpのレイアウトああああああああああああああああああ設定を読み込む

    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout');
    }

    public function index() 
    {
        $this->User->recursive = 0;
        $this->redirect("/graphs/index");
    }

    public function view($id = null) 
    {                
        $this->User->id = $id;
        if (!$this->User->exists()) 
        {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add()
    {
        $groupNameData = $this->setGroupNameWithAll('add');
        if ($this->request->is('post')) 
        {
            if($this->User->addUser($this->request->data['User'],$groupNameData))
            {
                $this->Session->setFlash(__('The user has been saved<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                $this->redirect(array('action' => 'index'));
            }
            else
            {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-warning alert-dismissable'));
            }
        }
    }
    public function edit($id = null) 
    {
        $this->User->id = $id;
        if (!$this->User->exists()) 
        {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put'))
        {
            if ($this->User->save($this->request->data)) 
            {
                $this->Session->setFlash(__('The user has been saved<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                $this->redirect(array('action' => 'index'));
            } else 
            {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-warning alert-dismissable'));
            }
        } else 
        {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) 
    {
        //adminはだれでも削除できる
        if ($this->request->is('post'))
        {
            $message = 'Invalid username or password, try again.';
            $username = $this->request['data']['User']['username'];
            $password = $this->request['data']['User']['password'];

            if($this->Auth->user('role') =='admin')
            {
                $param = array('username' => $username);
                if ($this->User->hasAny($param)) 
                {
                    $rollArray = $this->User->find('all', array("roll" => "admin"));
                    $numOfAdmin = count($rollArray);
                    if($numOfAdmin!=1)//ただし自分が最後のadminの場合は削除させない
                    {
                        if ($this->User->deleteAll($param,false)) 
                        {
                            $this->Session->setFlash(__('user deleted<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                            $this->redirect(array('action' => 'delete'));
                        }
                    }
                    $message = 'You are the last administrator.';
                }
            }
            //入力された名前とパスがログインユーザーのものと一致すればidで削除
            else if($username == $this->Auth->user('username'))
            {

                $id = $this->Auth->user('id');
                if ($this->User->exists($id)) 
                {
                    if ($this->User->delete($id)) 
                    {
                        $this->Session->setFlash(__('user deleted<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                        $this->redirect(array('action' => 'login'));
                    }
                }
            }

            $this->Session->setFlash(__($message.'<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
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
