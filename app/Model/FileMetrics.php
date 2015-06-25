<?php
class FileMetrics extends AppModel 
{
	private $depth = 0;

	public function getDepth()
	{
		return $this->depth;
	}
    function getMetricsTable($data) 
    {
    	$this->depth=0;
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
		$dataSize = count($data);
		for ($i = 0; $i < $dataSize; ++$i)
		{
			$filepath = $data[$i]['Graph']['file_path'];
			$path = explode('/',$filepath);
			$path[0] = trim($path[0]);
			$parent = &$tree;
			$children = &$tree["children"];
			$defact= $data[$i]['Graph'][3];
			$pathDepth=count($path);
			if($this->depth < $pathDepth)
			{
				$this->depth = $pathDepth;//ビューのレイヤー切り替えの最大値用に最深度を記録しておく
			}
	        for($j = 0; $j < $pathDepth-1; ++$j)
	        {
				$isTheDir = false;
				for ($k = 0; $k < count($children); ++$k)
				{
					$isTheDir = ($children[$k]["name"] == $path[$j]);
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
					$children = &$children[count($children) - 1]["children"];
				}
			}
			$parent["size"] += $defact;
			$children[] = array("name"=>$path[$pathDepth-1],"size"=>$defact,"layer"=> ($pathDepth));
		}
// echo '<pre>';
// print_r($tree);
// echo '</pre>';

    	return $tree;
    }
}
