<?php
class OriginChart extends AppModel 
{
    public $name = 'OriginChart';

    //model[由来0～7][欠陥数] = その欠陥数のファイル数
    function getOriginTable($data) 
    {
    	for ($i = 0; $i < count($data); ++$i)
	   	{
			$data[$i] = $data[$i]['Graph'];
		}
	   	//print_r($data);

	    //全ての由来で最大の欠陥数を求める。
	    $maxDefact = array(0,0,0,0,0,0,0,0);
	    for ($i = 0; $i < count($data); ++$i)
	    {
	    	$origin = $data[$i]['1'];
	        $defact = $data[$i]['3'];
	        $maxDefact[$origin] = max($maxDefact[$origin],$defact);
	    }
	    //それぞれの由来の欠陥数のテーブルを用意する
	    $model = array(array(),array(),array(),array(),array(),array(),array(),array());
	    for ($i = 0; $i < count($model); ++$i)
	    {
	        $table = array();
	        $model[$i] = array_pad($table,$maxDefact[$i]+1,0);
	    }


	    //欠陥数のテーブルを更新していく
	    for ($i = 0; $i < count($data); ++$i)
	    {
	        $origin = $data[$i]['1'];
	        $defact = $data[$i]['3'];

	        ++$model[$origin][$defact];
	    }
	   // 	    echo '<pre>';
    // print_r($model);
    // //print_r($model2);
    // 	   		    die();
    // echo '</pre>';

	    //print_r($model);
	    return $model;
    }
}
