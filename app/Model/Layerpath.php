<?php
App::uses('AppModel', 'Model');
/**
 * Layerpath Model
 *
 * @property Layer $Layer
 */
class Layerpath extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Layer' => array(
			'className' => 'Layer',
			'foreignKey' => 'layer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);



    function uploadFromCSV($filepath)
    {
        try
        {
            setlocale( LC_ALL, 'ja_JP.UTF-8' );
            $data = array();
            $buf = mb_convert_encoding(file_get_contents($filepath), "utf-8", 'ASCII,JIS,UTF-8,eucJP-win,SJIS-win');//sjis-win''
            $lines = str_getcsv($buf, "\n");
            $id = 0;
            foreach ($lines as $line)
            {
                $col = str_getcsv(trim($line));
                $data[] = array('id'=> ++$id ,'layer_id'=>$col[0], 'path'=>$col[1]);
            }

            $this->begin();

            if (!$this->saveAll($data))
            {
                throw new Exception();
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
    ///////csvのアップロード用///////
}
