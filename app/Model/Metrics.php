<?php
class Metrics extends AppModel 
{
    function getLayer($filePath)
    {
    	return mt_rand(0, 5);
    }
    function getMetricsTable($data) 
    {
    	//model名,レイヤー、全ファイル数、血管のあるファイル数、欠陥数
//data[0]=Array
		// (
		//     [Graph] => Array
		//         (
		//             [model] => testA
		//             [file_path] => vendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/ImsSenderRxr.java
		//             [3] => 1
		//         )

		// )
		$modelName = $data[0]['Graph']['model'];
    	$newData = array();
    	for ($i = 0; $i < 6; ++$i)
    	{
    		$newData[$i]=array('ModelLayer'=>
    							array(
									'model'           =>$modelName,
									'layer'           =>$i,
									'all_file_num'    =>0,
									'defect_file_num' =>0,
									'defect_num'      =>0
    								  )
    							);
    	}

    	for ($i = 0; $i < count($data); ++$i)
	   	{
	   		$defact = $data[$i]['Graph'][3];
			$filePath = $data[$i]['Graph']['file_path'];
			$layer = $this->getLayer($filePath);
			++$newData[$layer]['ModelLayer']['all_file_num'];
			if(0<$defact)
			{
				++$newData[$layer]['ModelLayer']['defect_file_num'] ;
				$newData[$layer]['ModelLayer']['defect_num'] += $defact;
			}
		}

    	return $newData;
    }
}
