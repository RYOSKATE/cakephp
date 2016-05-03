<?php
class Graph extends AppModel 
{
    public $belongsTo = array(
		'Modelname' => array(
			'className' => 'Modelname',
			'foreignKey' => 'modelname_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
        'Uploaddata' => array(
			'className' => 'Uploaddata',
			'foreignKey' => 'upload_data_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

    ///////csvのアップロード用///////
    function uploadFromCSV($fileName,$selectModelId,$upload_id) 
    {

    // php.iniの変更点
    // upload_max_filesize=32M  8万行のデータで約10MB
    // memory_limit=1024M       8万行のデータを以下の$ret[] に格納するのに約256MB
    // post_max_size=64M        8万行のデータを(ry
    // max_execution_time=180   8万行のデータをローカルサーバのデータベースにアップロードするのに約60秒かかった
        $allcsvData = array();
		$groupNameData = array();
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            setlocale( LC_ALL, 'ja_JP.UTF-8' );
        	$buf = mb_convert_encoding(file_get_contents($fileName), "utf-8", "auto");//sjis-win''
        	$lines = str_getcsv($buf, "\r\n");
        	foreach ($lines as $line) 
            {
                $col = str_getcsv($line);
                $data = array('modelname_id'=>$selectModelId,'upload_data_id'=>$upload_id,'filepath'=>$col[0]) + $col;
				$allcsvData[]  = $data;
                if(4<=$col[1])
                {
                    $names = explode(';',$col[25]);
                    for ($j = 0; $j< count($names); ++$j)
                    {
                        $name = trim($names[$j]);
                        if(!in_array($name, $groupNameData))
                        {
                            $groupNameData[]=$name;
                        }
                    }
                }
        	}
            $key = array_search('', $groupNameData);
            if($key)
                $groupNameData[$key]="グループ名なし";
            if (!$this->saveAll($allcsvData, array('validate' => 'first')))
            {
                throw new Exception();
            }

            $this->commit();
        }
        catch(Exception $e) 
        {
            $this->rollback();
            return null;
        }
        return $groupNameData;
    }
    ///////csvのアップロード用///////
    
    
    /////////全開発グループ用/////////
    function getGroupData($upload_data_id,$selectMetrics,$selectGroupName) 
    {
        //変数名defact_numは歴史的事情であり、実際には欠陥数以外のメトリクスも入る。
        $conditions = array('Graph.upload_data_id' => $upload_data_id);
		$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        //1:由来,3欠陥数,4物理行数,25グループ
        //x軸がファイル数、円の大きさは物理行数、y軸がメトリクスの図になる。
        $data = $this->find('all',array('fields' => array(1,3,$selectMetrics,4,25),'conditions' => $conditions));
        
        for ($i = 0; $i < count($data); ++$i)
        {
            $data[$i] = $data[$i]['Graph'];
        }

        $group_array = array();
        $numOfData = count($data);
        for ($i = 0; $i < $numOfData; ++$i) 
        {
            $names = explode(';',$data[$i][25]);
            $numOfNames = count($names);
            for ($j = 0; $j < $numOfNames; ++$j) 
            {
                $name = trim($names[$j]);
                $metrics = 1;//0の時はファイル数なので1
			    if($selectMetrics==1 && $data[$i]['3']==0)
			    {
    				$metrics = 0;//"(2) 欠陥ファイル数"の時は1以上なら1
	    		}else if(2<$selectMetrics)//3～欠陥数
				    $metrics = $data[$i][$selectMetrics];
                if(!isset($group_array[$name]))
                {
                    $group_names[] = $name;
                    $group_array += array($name=>array('file_num'=>1,'defact_num'=>$metrics,'loc'=>$data[$i][4]));
                }
                else
                {
                    $group_array[$name]['file_num']   += 1;
                    $group_array[$name]['defact_num'] += $metrics;
                    $group_array[$name]['loc']        += $data[$i][4];
                }
            }
        }

        $data = array();
        foreach ($group_array as $key => $value)
        {
            $data[]      = array(
                            'group_name' =>$key,
                            'file_num'   =>$value['file_num'],
                            'defact_num' =>$value['defact_num'],
                            'loc'        =>$value['loc'],
                            );
        }

        return $data;
    }
     /////////全開発グループ用/////////
     
     
    ///////ファイルメトリクス用///////
    function getFileMetricsTableFromCSV($up_file)
    {
        setlocale( LC_ALL, 'ja_JP.UTF-8' );
        $data = array();
        $buf = mb_convert_encoding(file_get_contents($up_file), "utf-8", "auto");//sjis-win''
        $lines = str_getcsv($buf, "\r\n");
        foreach ($lines as $line) 
        {
            $col = str_getcsv($line);
            if(4<=$col[1])//由来o3,o13,o23,o123のみ
            {
              $data[] = array('modelname_id'=> -1,'filepath'=>$col[0]) +$col;
            }
        }
        $this->depth=0;
        //model名,レイヤー、全ファイル数、血管のあるファイル数、欠陥数
//data[0]=Array
        // (
        //     [Graph] => Array
        //         (
        //             [model] => testA
        //             [filepath] => vendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/ImsSenderRxr.java
        //             [3] => 1//欠陥数
        //             [8] => 呼び出す他クラスの関数種類数
        //             [9] => メソッドの凝集度の欠如(LCOM)
        //             [10] =>Public メソッド数
        //             [11] =>Public 属性数
        //             [18] => 呼び出す他ファイルの関数の種類数
        //         )

        // )
         $tree = array("name"    =>   "root",
                "defact"         =>0,
                "otherClassFunc" =>0,
                "LCOM"           =>0,
                "Method"         =>0,
                "Field"          =>0,
                "otherFileFunc"  =>0,
                "layer"          =>0,
                "children"       => array());
        $dataSize = count($data);
        for ($i = 0; $i < $dataSize; ++$i)
        {
            $filepath = $data[$i]['filepath'];
            $path     = explode('/',$filepath);
            $path[0]  = trim($path[0]);
            $parent   = &$tree;
            $children = &$tree["children"];
            $defact         = $data[$i][3];
            $otherClassFunc = $data[$i][8];
            $LCOM           = $data[$i][9];
            $Method         = $data[$i][10];
            $Field          = $data[$i][11];
            $otherFileFunc  = $data[$i][18];

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
                        $parent["defact"]         += $defact;
                        $parent["otherClassFunc"] += $otherClassFunc;
                        $parent["LCOM"]           += $LCOM;
                        $parent["Method"]         += $Method;
                        $parent["Field"]          += $Field;
                        $parent["otherFileFunc"]  += $otherFileFunc;

                        $parent = &$children[$k];
                        $children[$k] += array("children"=> array());
                        $children = &$children[$k]["children"];
                        break;
                    }
                }

                if(!$isTheDir)//そのディレクトリが初めて登場した
                {
                    $node = array(
                                    "name"           =>$path[$j],
                                    "defact"         =>$defact,
                                    "otherClassFunc" =>$otherClassFunc,
                                    "LCOM"           =>$LCOM,
                                    "Method"         =>$Method,
                                    "Field"          =>$Field,
                                    "otherFileFunc"  =>$otherFileFunc,
                                    "layer"          =>($j+1),
                                 );
                    $children[] = $node;
                    $children = &$children[count($children) - 1]["children"];
                }
            }
            $parent["defact"]         += $defact;
            $parent["otherClassFunc"] += $otherClassFunc;
            $parent["LCOM"]           += $LCOM;
            $parent["Method"]         += $Method;
            $parent["Field"]          += $Field;
            $parent["otherFileFunc"]  += $otherFileFunc;
            $children[] = array(
                                "name"           =>$path[$pathDepth-1],
                                "defact"         =>$defact,
                                "otherClassFunc" =>$otherClassFunc,
                                "LCOM"           =>$LCOM,
                                "Method"         =>$Method,
                                "Field"          =>$Field,
                                "otherFileFunc"  =>$otherFileFunc,
                                "layer"          => ($pathDepth)
                            );
        }
 // echo '<pre>';
 // print_r($tree);
 // echo '</pre>';
        $tree=json_encode($tree);
        return $tree;
    }


    private $depth = 0;

    public function getDepth()
    {
        return $this->depth;
    }
    function getFileMetricsTable($selectUploadDataId,$selectGroupName) 
    {

        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
		$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        $data = $this->find('all',array('fields' => array('modelname_id','filepath','3','8','9','10','11','18'),'conditions' => $conditions));

        $this->depth=0;
        //model名,レイヤー、全ファイル数、血管のあるファイル数、欠陥数
        //data[0]=Array
        // (
        //     [Graph] => Array
        //         (
        //             [upload_data_id] => 2
        //             [filepath] => vendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/ImsSenderRxr.java
        //             [3] => 1//欠陥数
        //             [8] => 呼び出す他クラスの関数種類数
        //             [9] => メソッドの凝集度の欠如(LCOM)
        //             [10] =>Public メソッド数
        //             [11] =>Public 属性数
        //             [18] => 呼び出す他ファイルの関数の種類数
        //         )

        // )
                 $tree = array("name"    =>   "root",
                        "defact"           =>0,
                        "otherClassFunc" =>0,
                        "LCOM"           =>0,
                        "Method"         =>0,
                        "Field"          =>0,
                        "otherFileFunc"  =>0,
                        "layer"          =>0,
                        "children"       => array());
        $dataSize = count($data);

        for ($i = 0; $i < $dataSize; ++$i)
        {
            $filepath = $data[$i]['Graph']['filepath'];
            $path     = explode('/',$filepath);
            $path[0]  = trim($path[0]);
            $parent   = &$tree;
            $children = &$tree["children"];
            $defact         = $data[$i]['Graph'][3];
            $otherClassFunc = $data[$i]['Graph'][8];
            $LCOM           = $data[$i]['Graph'][9];
            $Method         = $data[$i]['Graph'][10];
            $Field          = $data[$i]['Graph'][11];
            $otherFileFunc  = $data[$i]['Graph'][18];

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
                        $parent["defact"]         += $defact;
                        $parent["otherClassFunc"] += $otherClassFunc;
                        $parent["LCOM"]           += $LCOM;
                        $parent["Method"]         += $Method;
                        $parent["Field"]          += $Field;
                        $parent["otherFileFunc"]  += $otherFileFunc;

                        $parent = &$children[$k];
                        $children[$k] += array("children"=> array());
                        $children = &$children[$k]["children"];
                        break;
                    }
                }

                if(!$isTheDir)//そのディレクトリが初めて登場した
                {
                    $node = array(
                                    "name"           =>$path[$j],
                                    "defact"         =>$defact,
                                    "otherClassFunc" =>$otherClassFunc,
                                    "LCOM"           =>$LCOM,
                                    "Method"         =>$Method,
                                    "Field"          =>$Field,
                                    "otherFileFunc"  =>$otherFileFunc,
                                    "layer"          =>($j+1),
                                 );
                    $children[] = $node;
                    $children = &$children[count($children) - 1]["children"];
                }
            }
            $parent["defact"]         += $defact;
            $parent["otherClassFunc"] += $otherClassFunc;
            $parent["LCOM"]           += $LCOM;
            $parent["Method"]         += $Method;
            $parent["Field"]          += $Field;
            $parent["otherFileFunc"]  += $otherFileFunc;
            $children[] = array(
                                "name"           =>$path[$pathDepth-1],
                                "defact"         =>$defact,
                                "otherClassFunc" =>$otherClassFunc,
                                "LCOM"           =>$LCOM,
                                "Method"         =>$Method,
                                "Field"          =>$Field,
                                "otherFileFunc"  =>$otherFileFunc,
                                "layer"          => ($pathDepth)
                            );
        }
 // echo '<pre>';
 // print_r($tree);
 // echo '</pre>';
        $tree=json_encode($tree);
        return $tree;
    }
    ///////ファイルメトリクス用///////


    ///////メトリクス比較用///////
    function getCompareMetricsTableFromCSV($up_file)
    {
        setlocale( LC_ALL, 'ja_JP.UTF-8' );
        $data = array();
        $buf = mb_convert_encoding(file_get_contents($up_file), "utf-8", "auto");//sjis-win''
        $lines = str_getcsv($buf, "\r\n");
        foreach ($lines as $line) 
        {
            $col = str_getcsv($line);
            if(4<=$col[1])//由来o3,o13,o23,o123のみ
            {
              $data[] = array('Graph'=>array('model'=>"localCSV",'filepath'=>$col[0]) +$col);
            }
        }

        $modelName = $data[0]['Graph']['model'];
        $newData = array();
        for ($i = 0; $i < 7; ++$i)
        {
            $newData[$i]=array('ModelLayer'=>
                                array(
                                    'model'           =>$modelName,
                                    'layer'           =>$i,
                                    'all_file_num'    =>0,
                                    'defect_file_num' =>0,
                                    'defect_per_file' =>0,
                                    'defect_num'      =>0,
                                     )
                                );
        }

        for ($i = 0; $i < count($data); ++$i)
        {
            $defact = $data[$i]['Graph'][3];
            $filePath = $data[$i]['Graph']['filepath'];
            $layer = $this->getLayer($filePath);
            if($layer < 0 ||6 < $layer)
            {
                continue;
            }
            ++$newData[$layer]['ModelLayer']['all_file_num'];
            if(0<$defact)
            {
                ++$newData[$layer]['ModelLayer']['defect_file_num'] ;
                $newData[$layer]['ModelLayer']['defect_num'] += $defact;
            }
        }
        //最後にファイル率を求める
        for ($i = 0; $i < count($newData); ++$i)
        {
            $temp = $newData[$i]['ModelLayer'];
            if($temp['all_file_num']!=0)
            {
                $newData[$i]['ModelLayer']['defect_per_file'] = 100*$temp['defect_file_num']/$temp['all_file_num'];
            }
        }
        //ファイル率計算時の0除算を防ぐため
        return $newData;
    }

    function getCompareMetricsTable($selectUploadDataId,$selectGroupName) 
    {
        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
		$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        $data = $this->find('all',array('Fields' => array('filepath','3'),'conditions' => $conditions));

        //model名,レイヤー、全ファイル数、欠陥のあるファイル数、欠陥数
//data[0]=Array
        // (
        //     [Graph] => Array
        //         (
        //             [model] => testA
        //             [filepath] => vendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/ImsSenderRxr.java
        //             [3] => 1
        //         )

        // )
        if(empty($data))
        {
            return null;
        }
        $modelName = $data[0]['Modelname']['name'];
        $newData = array();
        for ($i = 0; $i < 7; ++$i)
        {
            $newData[$i]=array('ModelLayer'=>
                                array(
                                    'model'           =>$modelName,
                                    'layer'           =>$i,
                                    'all_file_num'    =>0,
                                    'defect_file_num' =>0,
                                    'defect_per_file' =>0,
                                    'defect_num'      =>0,
                                     )
                                );
        }

        for ($i = 0; $i < count($data); ++$i)
        {
            $defact = $data[$i]['Graph'][3];
            $filePath = $data[$i]['Graph']['filepath'];
            $layer = $this->getLayer($filePath);
            if($layer < 0 ||6 < $layer)
            {
                continue;
            }
            ++$newData[$layer]['ModelLayer']['all_file_num'];
            if(0<$defact)
            {
                ++$newData[$layer]['ModelLayer']['defect_file_num'] ;
                $newData[$layer]['ModelLayer']['defect_num'] += $defact;
            }
        }
        //最後にファイル率を求める
        for ($i = 0; $i < count($newData); ++$i)
        {
            $temp = $newData[$i]['ModelLayer'];
            if($temp['all_file_num']!=0)
            {
                $newData[$i]['ModelLayer']['defect_per_file'] = 100*$temp['defect_file_num']/$temp['all_file_num'];
            }
        }
        //ファイル率計算時の0除算を防ぐため
        return $newData;
    }

    function getLayer($filePath)
    {
        //frameworksを含めていいのか要検討
        //vendor/fujitsu/やbootable/bootloaderなども
        
			// 0=>'アプリケーション(APP)',
			// 1=>'アプリケーションフレームワーク(FW)',
			// 2=>'ライブラリ(外部OSS)',
			// 3=>'Android Runtinme(SYSTEM)', 
			// 4=>'HWライブラリ',
			// 5=>'Kernel',
			// //5=>'Kernel/ドライバ/ブードローダー',
			// 6=>'Others',
            
        $path = explode('/',$filePath);//先頭フォルダ名
        $path[0] = trim($path[0]);
        $layer= 6;

        if($path[0]=='packages')
        {
            $layer = 0;
        }
        else if($path[0]=='frameworks')//frameworksを含めていいのか要検討
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
                    case 'libs':
                        $layer = 3;
                        break;
                    default:
                        $layer = 1;
                }
            }
        }
        else if($path[0]=='external')
        {
            $layer = 2;
        }
        else if($path[0]=='dalvik' || $path[0]=='libcore' || $path[0]=='system')
        {
            $layer = 3;
        }
        else if($path[0]=='hardware' || ($path[0]=='vendor' && $path[1]=='qcom' && $path[2]=='proprietary'))
        {
            //vendorのときはチップベンダー、製品リリースならば
            $layer = 4;
        }
        else if($path[0]=='kernel')
        {
            $layer = 5;
        }

        // if($layer == 0)
        // {
        // echo '<pre>';
        // print_r($filePath);
        // print_r($path);
        // echo '</pre>';
        // }
        return $layer;
    }
    ///////メトリクス比較用///////


    ///////由来比較用///////
        //model[由来0～7][欠陥数] = その欠陥数のファイル数
    function getOriginTableFromCSV($up_file)
    {
        setlocale( LC_ALL, 'ja_JP.UTF-8' );
        $data = array();
        $buf = mb_convert_encoding(file_get_contents($up_file), "utf-8", "auto");//sjis-win''
        $lines = str_getcsv($buf, "\r\n");
        foreach ($lines as $line) 
        {
            $col = str_getcsv($line);
            if(4<=$col[1])//由来o3,o13,o23,o123のみ
            {
              $data[] = array('model'=>"localCSV",'filepath'=>$col[0]) +$col;
            }
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
       //       echo '<pre>';
    // print_r($model);
    // //print_r($model2);
    //             // die();
    // echo '</pre>';

        //print_r($model);
        return $model;
    }

    //model[由来0～7][欠陥数] = その欠陥数のファイル数
    function getOriginTable($selectUploadDataId,$selectGroupName) 
    {
        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
		$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        $data = $this->find('all',array('Fields' => array('1','3'),'conditions' => $conditions));
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
       //       echo '<pre>';
    // print_r($model);
    // //print_r($model2);
    //             // die();
    // echo '</pre>';

        //print_r($model);
        return $model;
    }
    ///////由来比較用///////
    
    
    function getOriginCityFromCSV($up_file,$metricsNumber)
    {
		if($metricsNumber==2)//未使用
			return array(0,0,0,0,0,0,0,0);
			
        setlocale( LC_ALL, 'ja_JP.UTF-8' );
        $data = array();
        $buf = mb_convert_encoding(file_get_contents($up_file), "utf-8", "auto");//sjis-win''
        $lines = str_getcsv($buf, "\r\n");
        foreach ($lines as $line) 
        {
            $col = str_getcsv($line);
            //7由来全て用いる
            $data[] = array('model'=>"localCSV",'filepath'=>$col[0]) +$col;
            
            //if(4<=$col[1])//由来o3,o13,o23,o123のみ
            //{
            //  $data[] = array('model'=>"localCSV",'filepath'=>$col[0]) +$col;
            //}
        }
        
        //1は由来,2はファイル数,3は欠陥数
        //由来ごとのメトリクスの総数を調べる
        $valueByOrigin = array(0,0,0,0,0,0,0,0);
        for ($i = 0; $i < count($data); ++$i)
        {
            $origin = $data[$i]['1'];
            $metrics = 1;//0の時はファイル数なので1
			if($metricsNumber==1 && $data[$i]['3']==0)
			{
				$metrics = 0;//"(2) 欠陥ファイル数"の時は1以上なら1
			}
			else if(2<$metricsNumber)//3～欠陥数
				$metrics = $data[$i][$metricsNumber];
            if(0<$metrics)//-1が無効値の物がある
            	$valueByOrigin[$origin] += $metrics;
        }

        // echo '<pre>';
        // print_r($valueByOrigin);
        // die();
        // echo '</pre>';
        // print_r($valueByOrigin);
        return $valueByOrigin;
    }
    
    //model[由来0～7] = その由来のメトリクスサイズ(3は欠陥数)
    function getOriginCity($selectUploadDataId,$selectGroupName,$metricsNumber) 
    {
		if($metricsNumber==2)//未使用
			return array(0,0,0,0,0,0,0,0);
			
        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        //1は由来,2はファイル数,3は欠陥数
        $data = $this->find('all',array('Fields' => array('1',$metricsNumber),'conditions' => $conditions));
        for ($i = 0; $i < count($data); ++$i)
        {
            $data[$i] = $data[$i]['Graph'];
        }
        //print_r($data);

        //由来ごとのメトリクスの総数を調べる
        $valueByOrigin = array(0,0,0,0,0,0,0,0);
        for ($i = 0; $i < count($data); ++$i)
        {
            $origin = $data[$i]['1'];
            $metrics = 1;//0の時はファイル数なので1
			if($metricsNumber==1 && $data[$i]['3']==0)
			{
				$metrics = 0;//"(2) 欠陥ファイル数"の時は1以上なら1
			}
			else if(2<$metricsNumber)//3～欠陥数
				$metrics = $data[$i][$metricsNumber];
			if(0<$metrics)//-1が無効値の物がある
            	$valueByOrigin[$origin] += $metrics;
        }

        // echo '<pre>';
        // print_r($valueByOrigin);
        // die();
        // echo '</pre>';
        // print_r($valueByOrigin);
        return $valueByOrigin;
    }
    ///////由来比較用///////
        //model[由来0～7] = その由来のメトリクスサイズ(3は欠陥数)
    function getOriginCity2($selectUploadDataId,$selectGroupName,$metricsNumber) 
    {	
    // 0L"(1) フォルダ／ファイル名",
	// 1L"(2) 由来(1 - 7 = 2,12,1,13,123,23,3)",
	// 2L"(3) 未使用",
	// 3L"(4) 欠陥の数",
	// 4L"(5) 物理行数",
    // 5L"(25) 手を加えた組織の数",
            
        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }

        //1は由来,2はファイル数,3は欠陥数
        $data = array();//origin=>全レイヤーのメトリクスの合計・layer=>そのレイヤーのメトリクスの合計
        for($i = 1;$i<=7;++$i)
        {
            $ori_cond = $conditions + array('Graph.1' => $i);
            $tmp_data = $this->find('all',array('fields' => array('filepath',$metricsNumber,'3'),'conditions' => $ori_cond));
            $layers = array('numOfFiles'=>0,'layerHeight'=>array(0,0,0,0,0,0,0));
            foreach ($tmp_data as $line) 
            {
                $metrics = 1;//0の時は(1)ファイル数なので1
                if($metricsNumber==1 && $line['Graph']['3']==0)
			    {
				    $metrics = 0;//"1のときは(2) 欠陥ファイル数"なので'3'が1以上なら1
			    }
                else if(2<$metricsNumber)//3～欠陥数
				    $metrics = $line['Graph'][$metricsNumber];           
                if($metrics<0)
                    $metrics=0;
                $layer =  $this->getLayer($line['Graph']['filepath']);
                ++$layers['numOfFiles'];
                $layers['layerHeight'][$layer]+=$metrics;
            }
            $data[$i] = $layers;
        }
        
        $sumOfValue=0;
        for($i = 1;$i<=7;++$i)
        {
            for($j = 0;$j<=6;++$j)
            {
                $sumOfValue = $data[$i]['layerHeight'][$j];
            }
        }
        if($sumOfValue==0)
            $data[0]=0;
        return $data;
    }
}
