<?php
App::uses('AppModel', 'Model');
/**
 * UploadData Model
 *
 * @property Modelname $Modelname
 * @property User $User
 * @property Graph $Graph
 */
class UploadData extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modelname_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'comment' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Modelname' => array(
			'className' => 'Modelname',
			'foreignKey' => 'modelname_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Graph' => array(
			'className' => 'Graph',
			'foreignKey' => 'upload_data_id',
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
    function upload($comment,$upload_date,$selectModelId,$user_id) 
     {
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            $time = date('Y-m-d', mktime(0, 0, 0,$upload_date['month'], $upload_date['day'],$upload_date['year']));
            $data = array('date'=>$time,'modelname_id' =>$selectModelId,'user_id'=>$user_id,'comment'=>$comment);
            if (!$this->save($data)) 
            {
                throw new Exception();
            }
            $this->commit();
        }
        catch(Exception $e) 
        {
            $this->rollback();
            return 0;
        }
		$id = $this->getLastInsertID();
        return $id;
    }
}
