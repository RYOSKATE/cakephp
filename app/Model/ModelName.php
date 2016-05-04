<?php
App::uses('AppModel', 'Model');
/**
 * ModelName Model
 *
 */
class ModelName extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
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

	function addNewModelName($newModelName)
	{
		try
		{
			//$this->begin();//トランザクション(永続的な接続処理の開始)
		
			$data['name'] = $newModelName;
		
			if (!$this->saveAll($data)) 
			{
				throw new Exception();
			}
		
			//$this->commit();
		}
		catch(Exception $e) 
		{
			//$this->rollback();
			return 0;
		}
		$id = $this->getLastInsertID();
		return $id;
	}
}
