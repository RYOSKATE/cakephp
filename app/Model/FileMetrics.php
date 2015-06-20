<?php
class FileMetrics extends AppModel 
{
    function getMetricsTable($data) 
    {
    	//model名,レイヤー、全ファイル数、血管のあるファイル数、欠陥数
//data[0]=Array
		// (
		//     [Graph] => Array
		//         (
		//             [model] => testA
		//             [file_path] => vendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/ImsSenderRxr.java
		//             [3] => 1//欠陥数
		//			   [8] => 呼び出す他クラスの関数種類数
		//			   [9] => メソッドの凝集度の欠如(LCOM)
		//			   [18] => 呼び出す他ファイルの関数の種類数
		//         )

		// )
		// $modelName = $data[0]['Graph']['model'];
  //   	$newData = array();
  //   	for ($i = 0; $i < 6; ++$i)
  //   	{
  //   		$newData[$i]=array('ModelLayer'=>
  //   							array(
		// 							'model'           =>$modelName,
		// 							'layer'           =>$i,
		// 							'all_file_num'    =>0,
		// 							'defect_file_num' =>0,
		// 							'defect_per_file' =>0,
		// 							'defect_num'      =>0,
  //   								 )
  //   							);
  //   	}

  //   	for ($i = 0; $i < count($data); ++$i)
	 //   	{
	 //   		$defact = $data[$i]['Graph'][3];
		// 	$filePath = $data[$i]['Graph']['file_path'];
		// 	$layer = $this->getLayer($filePath);
		// 	if($layer < 0 ||5 < $layer)
		// 	{
		// 		continue;
		// 	}
		// 	++$newData[$layer]['ModelLayer']['all_file_num'];
		// 	if(0<$defact)
		// 	{
		// 		++$newData[$layer]['ModelLayer']['defect_file_num'] ;
		// 		$newData[$layer]['ModelLayer']['defect_num'] += $defact;
		// 	}
		// }
		// //最後にファイル率を求める
		// for ($i = 0; $i < count($newData); ++$i)
		// {
		// 	$temp = $newData[$i]['ModelLayer'];
		// 	$newData[$i]['ModelLayer']['defect_per_file'] = 100*$temp['defect_file_num']/$temp['all_file_num'];
		// }
		//ファイル率計算時の0除算を防ぐため
        $tree = array(
                "name"=>"Sample data",
                "children"=> array(
                    array(
                           "name"=>"Title 1",
                           "size"=>1,
                           "children"=>array(
                             array
                             (
                                 "name"=> "Title 1-1", "size"=>1,
                                 "children"=> array(
                                    array("name"=> "1-1-1", "size"=> 1),
                                    array("name"=> "1-1-2", "size"=> 1),
                                    array("name"=> "1-1-3", "size"=> 1),
                                    array("name"=> "1-1-4", "size"=> 1)
                                  )
                              ),  
                              array(
                                 "name"=> "Title 1-2", "size"=>1,
                                 "children"=> array(
                                    array("name"=> "1-2-1", "size"=> 1),
                                    array("name"=> "1-2-2", "size"=> 1),
                                    array("name"=> "1-2-3", "size"=> 1)
                                  )
                              ),  
                              array(
                                 "name"=> "Title 1-3", "size"=>1,
                                 "children"=> array(
                                    array("name"=> "1-3-1", "size"=> 1)
                                  )
                              )
                            )
                        ))
                );

    	return $tree;
    }

    function getLayer($filePath)
    {
    	//frameworksを含めていいのか要検討
    	//vendor/fujitsu/やbootable/bootloaderなども

    	$path = explode('/',$filePath);//先頭フォルダ名
    	$path[0] = trim($path[0]);
    	$layer= -1;

		if($path[0]=='packages')
    	{
    		$layer = 0;
    	}
    	else if($path[0]=='framework'/* || $path[0]=='frameworks'*/)//frameworksを含めていいのか要検討
    	{
    		if($path[1]=='ex' || $path[1]=='opt')
    		{
    			$layer = 1;
    		}
    		else if($path[1]=='base')
    		{
	    		switch ($path[2]) 
	    		{
	    			case 'packages':
	    				$layer = 0;
	    				break;
				    case 'cmds':
				    case 'core':
				    case 'data':
				    case 'docs':
				    case 'graphics':
				    case 'keystore':
				    case 'location':
				    case 'media':
				    case 'native':
				    case 'nfc-extras':
				    case 'obex':
				    case 'opengl':
				    case 'policy':
				    case 'sax':
				    case 'services':
				    case 'telephony':
				    case 'test-runner':
				    case 'tests':
				    case 'tools':
				    case 'voip':
				    case 'vpn':
				    case 'wifi':
				    	$layer = 1;
				    case 'libs':
				    	$layer = 2;
				    default:
				}
			}
    	}
    	else if($path[0]=='external')
    	{
    		$layer = 2;
    	}
    	else if($path[0]=='dalvik' || $path[0]=='libcore' || $path[0]=='system')
    	{
    		$layer = 2;
    	}
    	else if($path[0]=='hardware' || ($path[0]=='vendor' && $path[1]=='qcom' && $path[2]=='proprietary'))
    	{
    		//vendorのときはチップベンダー、製品リリースならば
    		$layer = 4;
    	}
		else if($path[0]=='kernel')
		{
    		switch ($path[1]) 
    		{
			    case 'arch':
			    	if($path[2]!='arm')
			    		break;
			    case 'block':
			    case 'crypto':
			    case 'drivers':
			    case 'firmware':
			    case 'fs':
			    case 'init':
			    case 'ipc':
			    case 'kernel':
			    case 'lib':
			    case 'mm':
			    case 'net':
			    case 'samples':
			    case 'scripts':
			    case 'security':
			    case 'sound':
			    case 'tools':
			    case 'usr':
			    case 'virt':
			    	$layer = 5;
			    default:
			}
		}

		if($layer == -1)
		{
			// echo '<pre>';
			// print_r($filePath);
			// echo '</pre>';
			//デバッグ用に今はランダムな値を入れる
			if(mt_rand(0,1))
				$layer = 1;
			else
				$layer = 3;
		}
    	return $layer;
    }
}
