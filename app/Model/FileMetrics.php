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
		$tree = array("name"=>"root","size"=>1,"children"=> array());
		for ($i = 0; $i < count($data)/10000; ++$i)
		{
			$filepath = $data[$i]['Graph']['file_path'];
			$path = explode('/',$filepath);
			$path[0] = trim($path[0]);
			$next = &$tree["children"];
	        for($j = 0; $j < count($path); ++$j)
	        {
				$node = array("name"=>$path[$j],"size"=>1);
				$is = false;
				for ($k = 0; $k < count($next); ++$k)
				{
					$is = $next[$k]["name"] == $path[$j];
					if($is)
					{
						$next[$k] += array("children"=> array());
						$next = &$next[$k]["children"];
						break;
					}
				}

				if(!$is)
				{
					$next[] = $node;
					if($j+1 < count($path))
					{
						$next = &$next[0]["children"];
					}
				}
			}
		}
		      //   echo '<pre>';
        //     print_r($tree);
        //     //die();
        // echo '</pre>';

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
