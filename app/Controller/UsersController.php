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
        if ($this->request->is('post')) 
        {
            $this->User->create();
            if ($this->User->save($this->request->data)) 
            {
                $this->Session->setFlash(__('The user has been saved<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                $this->redirect(array('action' => 'index'));
            } else 
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
        //$this->request->onlyAllow('post');

         $this->User->id = $id;
        // if (!$this->User->exists()) {
        //     throw new NotFoundException(__('Invalid user'));
        // }
        // if ($this->User->delete()) {
        //     $this->Session->setFlash(__('User deleted'));
        //     $this->redirect(array('action' => 'index'));
        // }
        // $this->Session->setFlash(__('User was not deleted'));
        // $this->redirect(array('action' => 'index'));
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
