<?php

App::uses('AppModel', 'Model');
/**
 * GroupName Model
 *
 */
class GroupName extends AppModel {

    public $useTable = 'group_names';

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

    function uploadFromCSV($groupNames,$isCodeCheck)
    {
        $errorNames=array();
        try
        {
            //$this->begin();//トランザクション(永続的な接続処理の開始)
            setlocale( LC_ALL, 'ja_JP.UTF-8' );
            $result = array_unique($groupNames);
 			$data = array();
            foreach($result as $name)//何故か空白文字のグループ名が毎回追加されてしまうため1から
            {
                // if($isCodeCheck && !mb_check_encoding($name,'UTF-8'))
				//     $errorNames[] = $name;
				$name = mb_convert_encoding($name, "utf-8", "auto");//sjis-win''
                if(!$this->hasAny(array('GroupName.name'=>$name)))
                    $data[] = array('name'=> $name);
            }

            if($errorNames)
                throw new Exception();
            if($data)
            {
                if (!$this->saveAll($data))
                {
                    $errorNames[0]='saveError';
                    throw new Exception();
                }
            }
            //$this->commit();
        }
        catch(Exception $e)
        {
            //$this->rollback();
        }
        return $errorNames;
    }
}
