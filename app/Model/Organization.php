<?php
App::uses('AppModel', 'Model');
/**
 * Organization Model
 *
 */
class Organization extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

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
                $data[] = array('id'=> ++$id ,'name'=>$col[0]);
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
}
