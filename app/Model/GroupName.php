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
    
    function uploadFromCSV($groupNames) 
    {

    // php.iniの変更点
    // upload_max_filesize=32M  8万行のデータで約10MB
    // memory_limit=1024M       8万行のデータを以下の$ret[] に格納するのに約256MB
    // post_max_size=64M        8万行のデータを(ry
    // max_execution_time=180   8万行のデータをローカルサーバのデータベースにアップロードするのに約60秒かかった
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            setlocale( LC_ALL, 'ja_JP.UTF-8' );
            $result = array_unique($groupNames);
            $databaseData = $this->find('list',array('fields' => 'name'));
 			$data = array();

            foreach($result as $name)//何故か空白文字のグループ名が毎回追加されてしまうため1から
            {
                if(!in_array($name, $databaseData))
                    $data[] = array('name'=> $name);
            }

            if($data)
            {
                if (!$this->saveAll($data)) 
                {
                    throw new Exception();
                }
            }
            $this->commit();
        }
        catch(Exception $e) 
        {
            $this->rollback();
            return false;
        }
        return true;
    }    
}
