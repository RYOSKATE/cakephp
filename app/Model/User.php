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
        'group' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A group is required'
            )
        ),

    );
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Sticky' => array(
			'className' => 'Sticky',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UploadData' => array(
			'className' => 'UploadData',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
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
