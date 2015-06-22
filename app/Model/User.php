<?php
// app/Model/User.php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class User extends AppModel 
{
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('isUnique'),
                'message' => 'This username has already been registered'
            )
        ),
        'group' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A group is required'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'author','reader')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),

    );

    public function deleteAccount($username,$password)
    {
        $param = array('username' => $username);
        if ($this->Model->deleteAll($param)) 
        {
        // 成功
        }
    }

    public function beforeSave($options = array()) 
    {
        if (isset($this->data[$this->alias]['password'])) 
        {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    }

}
