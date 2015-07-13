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


    public function beforeSave($options = array()) 
    {
        if (isset($this->data[$this->alias]['password'])) 
        {
            $passwordHasher = new SimplePasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    }

    //開発グループをカンマ区切りの文字列に加工して送信
    public function addUser($userData,$groupNameData)
    {
        //$userData = $this->request->data['User'];
        $this->create();
        $idArray = $this->find('first', array("fields" => "MAX(User.id) as max_id"));
        $id = reset($idArray)['max_id'] + 1;
        $userData['id'] = $id;
        foreach ($userData['group'] as &$value)
        {
            $value = $groupNameData[$value];
        }
        $userData['group'] = implode(",", $userData['group']);

        return $this->save($userData);
    }

    public function IsRegisteredNoUser()
    {
        $is = $this->find('all');
        return empty($is);
    }
}
