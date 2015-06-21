<?php
class FileMetrics extends AppModel 
{
	private $layerMax = 0;

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
		$tree = array("name"=>"root","size"=>1,"layer"=>0,"children"=> array());
		$dataSize = count($data)/10;
		for ($i = 0; $i < $dataSize; ++$i)
		{
			$filepath = $data[$i]['Graph']['file_path'];
			$path = explode('/',$filepath);
			$path[0] = trim($path[0]);
			$parent = &$tree;
			$children = &$tree["children"];
			$defact= $data[$i]['Graph'][3];
	        for($j = 0; $j < count($path); ++$j)
	        {
				$isTheDir = false;
				for ($k = 0; $k < count($children); ++$k)
				{
					$isTheDir = $children[$k]["name"] == $path[$j];
					if($isTheDir)//そのディレクトリが存在した
					{
						$parent["size"] += $defact;
						$parent = &$children[$k];
						$children[$k] += array("children"=> array());
						$children = &$children[$k]["children"];
						break;
					}
				}

				if(!$isTheDir)//そのディレクトリが初めて登場した
				{
					$node = array("name"=>$path[$j],"size"=>$defact,"layer"=> ($j+1));
					$children[] = $node;
					if($j+1 < count($path))
					{
						$children = &$children[count($children) - 1]["children"];
					}

				}
			}
		}
        // $tree = array(
        //         "name"=>"root",
        //         "children"=> array(
        //             array(
        //                    "name"=>"Title 1",
        //                    "size"=>1,
        //                    "children"=>array(
        //                      array
        //                      (
        //                          "name"=> "Title 1-1",
        //                          "size"=>1,
        //                          "children"=> array(
        //                             array("name"=> "1-1-1", "size"=> 1),
        //                             // array("name"=> "1-1-2", "size"=> 1),
        //                             // array("name"=> "1-1-3", "size"=> 1),
        //                             // array("name"=> "1-1-4", "size"=> 1)
        //                           )
        //                       ),  
        //                       // array(
        //                       //    "name"=> "Title 1-2", 
        //                       //    "size"=>1,
        //                       //    "children"=> array(
        //                       //       array("name"=> "1-2-1", "size"=> 1),
        //                       //       array("name"=> "1-2-2", "size"=> 1),
        //                       //       array("name"=> "1-2-3", "size"=> 1)
        //                       //     )
        //                       // ),  
        //                       // array(
        //                       //    "name"=> "Title 1-3", "size"=>1,
        //                       //    "children"=> array(
        //                       //       array("name"=> "1-3-1", "size"=> 1)
        //                       //     )
        //                       // )
        //                     )
        //                 ))
        //         );
        // echo '<pre>';
        //     print_r($tree);
        // echo '</pre>';
    	return $tree;
    }
}
