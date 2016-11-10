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

    function makeCacheName($graphName,$paramArray)
    {
        $str = $graphName;
        foreach ($paramArray as $param)
        {
            $str += "_";
            $str += $param;
        }
        return $str;
    }

    function readCSV($filepath,$selectModelId=-1,$upload_id=-1)
    {
        $records = array();
        $file = new SplFileObject($filepath); 
        $file->setFlags(SplFileObject::READ_CSV); 
        foreach ($file as $line) {
            $records[] = array('Graph'=>$line + array('modelname_id'=>$selectModelId,'upload_data_id'=>$upload_id,'filepath'=>$line[0])); 
        }

        if(!isset($records[count($records)-1]['Graph'][1]))
            unset($records[count($records)-1]);//最後に[0]だけのものができてしまうため削除
	    return $records;
    }
    
    //欠陥ファイル数、
    function getMetricsValue($col,$selectMetrics)
    {
        $metrics = 1;//0の時はファイル数なので1
        if($selectMetrics==1 && $col[3]==0)
        {
            $metrics = 0;//"(2) 欠陥ファイル数"の時は1以上なら1
        }else if(2<$selectMetrics)//3～欠陥数
            $metrics = $col[$selectMetrics];
        if($metrics<0)
            return 0;
        return $metrics;
    }
    ///////csvのアップロード用///////
    function uploadFromCSV($filepath,$selectModelId,$upload_id) 
    {
    // php.iniを変更する場合
    // memory_limit=1024M       8万行のデータを以下の$ret[] に格納するのに約256MB
    // post_max_size=64M        8万行のデータを(ry
    // upload_max_filesize=32M  8万行のデータで約10MB
    // max_execution_time=180   8万行のデータをローカルサーバのデータベースにアップロードするのに約60秒かかった
        //AppControllerのbeforeFilterで設定している
		$groupNameData = array();
        try
        {
            //ini_set('memory_limit', -1);

            //$this->begin();//トランザクション(永続的な接続処理の開始)
            
            $records = array();
            {
                $file = new SplFileObject($filepath); 
                $file->setFlags(SplFileObject::READ_CSV); 
                foreach ($file as $line) {
                    $records[] = $line; 
                }
            }
            unset($records[count($records)-1]);//最後に[0]だけのものができてしまうため削除
        	for ($i = 0; $i< count($records); ++$i)
            {
                $records[$i] += array('modelname_id'=>$selectModelId,'upload_data_id'=>$upload_id,'filepath'=>$records[$i][0]);
                if(4<=$records[$i][1])
                {
                    if($records[$i][25]=='')
                        $records[$i][25] = 'グループ名なし';
                        
                    //グループ名は;で区切られている
                    $names = explode(';',$records[$i][25]);
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
            //ここまではたぶん数秒で終わる
            if (!$this->saveAll($records))
            {
                throw new Exception();
            }

            //$this->commit();
        }
        catch(Exception $e) 
        {
            //$this->rollback();
            return null;
        }
        return $groupNameData;
    }
    ///////csvのアップロード用///////
    
    
    /////////全開発グループ用/////////
    
    
    function getGroupDataFromCSV($up_file,$selectMetrics)
    {   
        $data = $this->readCSV($up_file,-1,-1);
        $data = array_filter($data, function($row) {return $row['Graph'][25];});
        return $this->getGroupDataImple($data, $selectMetrics);
    }
    
    function getGroupData($upload_data_id,$selectMetrics,$selectGroupName)
    {
        $conditions = array('Graph.upload_data_id' => $upload_data_id);
		$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        
        $fields = array(1,3,$selectMetrics,4,25);     
        $data = $this->find('all',array('fields' => $fields,'conditions' => $conditions));
        return $this->getGroupDataImple($data,$selectMetrics);
    }
        
    function getGroupDataImple($data,$selectMetrics) 
    {
        $group_array = array();
        foreach($data as $value)
        {
            $names = explode(';',$value['Graph'][25]);
            $numOfNames = count($names);
            foreach($names as $name)
            {
                $name = trim($name);
                $metrics = $this->getMetricsValue($value['Graph'],$selectMetrics);
                $loc = $value['Graph'][4];
                if(!isset($group_array[$name]))
                {
                    $group_array += array($name=>array('file_num'=>1,'defact_num'=>$metrics,'loc'=>$loc));
                }
                else
                {
                    $group_array[$name]['file_num']   += 1;
                    $group_array[$name]['defact_num'] += $metrics;
                    $group_array[$name]['loc']        += $loc;
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
    private $depth = 0;

    public function getDepth()
    {
        return $this->depth;
    }
        
    function getFileMetricsTableFromCSV($up_file,$selectMetrics,$chartMetrics)
    {   
        $data = $this->readCSV($up_file,-1,-1);
        return $this->getFileMetricsTableImple($data, $selectMetrics,$chartMetrics);
    }

    function getFileMetricsTable($selectUploadDataId,$selectGroupName,$selectMetrics,$chartMetrics) 
    {

        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
		$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        
        $fields = array_merge(array('modelname_id','filepath',$selectMetrics),$chartMetrics);     
        $data = $this->find('all',array('fields' => $fields,'conditions' => $conditions));
        return $this->getFileMetricsTableImple($data,$selectMetrics,$chartMetrics);
    }

    function getFileMetricsTableImple($data, $selectMetrics,$chartMetrics)
    {
        $this->depth=0;
        //例：model名,レイヤー、全ファイル数、血管のあるファイル数、欠陥数
        //data[0]=Array
        // (
        //     [Graph] => Array
        //         (
        //             [upload_data_id] => 2
        //             [filepath] => vendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/ImsSenderRxr.java
        //             [3] => 1//欠陥数
        //             [8] => 呼び出す他クラスの関数種類数
        //             [$selectMetrics] => 選択されたメトリクス
        //         )
        // )

      
        //木の初期化
        $tree = array('name'    =>   "root",
            'metrics'         =>0,
            'layer'          =>0,
            'children'       => array());
        foreach($chartMetrics as $metNum)
        {
            $tree['metrics' . $metNum] = 0;
        }
        $dataSize = count($data);

        for ($i = 0; $i < $dataSize; ++$i)
        {
            $filepath = $data[$i]['Graph']['filepath'];
            $path     = explode('/',$filepath);
            $path[0]  = trim($path[0]);
            $parent   = &$tree;
            $children = &$tree['children'];
            $c_metrics = array();
            foreach($chartMetrics as $metNum)
            {
                $c_metrics['metrics' . $metNum] = $this->getMetricsValue($data[$i]['Graph'],$metNum);
            }
            $metrics = $this->getMetricsValue($data[$i]['Graph'],$selectMetrics);
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
                    $isTheDir = ($children[$k]['name'] == $path[$j]);
                    if($isTheDir)//そのディレクトリが存在した
                    {
                        foreach($chartMetrics as $metNum)
                        {
                            $parent['metrics' . $metNum] += $c_metrics['metrics' . $metNum];
                        }                        
                        $parent['metrics']         += $metrics;
                        $parent = &$children[$k];
                        $children[$k] += array('children'=> array());
                        $children = &$children[$k]['children'];
                        break;
                    }
                }

                if(!$isTheDir)//そのディレクトリが初めて登場した
                {
                    $node = array(
                                    'name'           =>$path[$j],
                                    'metrics'        =>$metrics,
                                    'layer'          =>($j+1),
                                 );
                    foreach($chartMetrics as $metNum)
                    {
                        $node['metrics' . $metNum] = $c_metrics['metrics' . $metNum];
                    }                                   
                    $children[] = $node;
                    $children = &$children[count($children) - 1]['children'];
                }
            }
            foreach($chartMetrics as $metNum)
            {
                $parent['metrics' . $metNum] += $c_metrics['metrics' . $metNum];
            }               
            $tmp_array = array(
                                'metrics'        =>$metrics,
                                'name'           =>$path[$pathDepth-1],
                                'layer'          => ($pathDepth)
                            );
            foreach($chartMetrics as $metNum)
            {
                $tmp_array['metrics' . $metNum] = $c_metrics['metrics' . $metNum];
            }                                  
            $children[] = $tmp_array;
            $parent['metrics']        += $metrics;
            foreach($chartMetrics as $metNum)
            {
                $node['metrics' . $metNum] = $c_metrics['metrics' . $metNum];
            }                                
        }

        $tree=json_encode($tree);
        return $tree;        
    }

    ///////ファイルメトリクス用///////


    ///////メトリクス比較用///////
    function getCompareMetricsTableFromCSV($up_file,$selectMetrics)
    {
        $data = $this->readCSV($up_file,-1,-1);
        return $this->getCompareMetricsTableImple($data, $selectMetrics);
    }

    function getCompareMetricsTable($selectUploadDataId,$selectGroupName,$selectMetrics) 
    {
        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
		$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        $data = $this->find('all',array('fields' => array('filepath','3',$selectMetrics),'conditions' => $conditions));

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
        return $this->getCompareMetricsTableImple($data,$selectMetrics);
    }
    function getCompareMetricsTableImple($data,$selectMetrics)
    {
        if(empty($data))
        {
            return null;
        }
        //$modelName = $data[0]['Modelname']['name'];
        $newData = array();
        for ($i = 0; $i < 7; ++$i)
        {
            $newData[$i]=array('ModelLayer'=>
                                array(
                                    //'model'           =>$modelName,
                                    'layer'           =>$i,
                                    'all_file_num'    =>0,
                                    'defect_file_num' =>0,
                                    'defect_per_file' =>0,
                                    'defect_num'      =>0,
                                    'metrics'         =>0,
                                     )
                                );
        }

        for ($i = 0; $i < count($data); ++$i)
        {
            $defact = $data[$i]['Graph'][3];
            $metrics = $this->getMetricsValue($data[$i]['Graph'],$selectMetrics);
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
            $newData[$layer]['ModelLayer']['metrics'] += $metrics;
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
    function getOriginTableFromCSV($up_file,$selectMetrics)
    {
        $data = $this->readCSV($up_file,-1,-1);
        return $this->getOriginTableImple($data,$selectMetrics);   
    }

    //model[由来0～7][欠陥数] = その欠陥数のファイル数
    function getOriginTable($selectUploadDataId,$selectGroupName,$selectMetrics) 
    {
        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
		$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        $data = $this->find('all',array('fields' => array('1',$selectMetrics),'conditions' => $conditions));
        
        return $this->getOriginTableImple($data,$selectMetrics);
    }
    
    function getOriginTableImple($data,$selectMetrics)
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
            $defact = $this->getMetricsValue($data[$i],$selectMetrics);
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
            $defact = $this->getMetricsValue($data[$i],$selectMetrics);

            ++$model[$origin][$defact];
        }

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
        $cName = $this->makeCacheName("origincity",array($selectUploadDataId,$selectGroupName,$metricsNumber));
        App::uses('Cache', 'Cache');
        $ret = Cache::read($cName);
        if($ret !== false) {
echo '<pre>';
print_r("using cache");
//print_r($ret);
echo '</pre>';
            return $ret;
        }

		if($metricsNumber==2)//未使用
			return array(0,0,0,0,0,0,0,0);
			
        $conditions = array('Graph.upload_data_id' => $selectUploadDataId);
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        //1は由来,2はファイル数,3は欠陥数

        $fields = array('filepath' ,'1',$metricsNumber);
echo '<pre>';
print_r(date( "Y年m月d日 H時i分s秒" ) );
//print_r($fields);
echo '</pre>';


        $data = $this->find('all',array('fields' => $fields,'conditions' => $conditions,'recursive'=>-1));
echo '<pre>';
print_r(date( "Y年m月d日 H時i分s秒" ) );
//print_r($data);
echo '</pre>';

        $newData = array();
        for($i = 1;$i<=7;++$i)
        {
            $layers = array('numOfFiles'=>0,'height'=>0,'layerHeight'=>array(0,0,0,0,0,0,0));
            $dataByOrigin = array_filter($data, function($d)use($i) {return $d['Graph'][1]==$i;});
            foreach ($dataByOrigin as $line) 
            {
                $metrics = $this->getMetricsValue($line['Graph'], $metricsNumber);
                $layer =  $this->getLayer($line['Graph']['filepath']);
                ++$layers['numOfFiles'];
                $layers['layerHeight'][$layer]+=$metrics;
            }
            $newData[$i] = $layers;
        }

        $sumOfValue=0;
        for($i = 1;$i<=7;++$i)
        {
            $height = 0;
            for($j = 0;$j<=6;++$j)
            {
                $height += $newData[$i]['layerHeight'][$j];
            }
            $newData[$i]['height'] = $height;
            $sumOfValue += $height;
        }
        if($sumOfValue==0)
            $newData[0]=0;

        Cache::write($cName, $newData);
echo '<pre>';
print_r(date( "Y年m月d日 H時i分s秒" ) );
//print_r($newData);
echo '</pre>';
        return $newData;
    }
    
    ///////OriginCity(3D)用///////
    function getOriginCity2FromCSV($up_file,$selectMetrics)
    {   
        $data = $this->readCSV($up_file,-1,-1);
        return $this->getOriginCity2Imple($data, $selectMetrics);
    }
    
    function getOriginCity2($selectModelId,$selectGroupName,$selectMetrics) 
    {
        $conditions = array('Graph.modelname_id' => $selectModelId);
		//由来比較なので全部取得　$conditions += array('Graph.1 >=' => 4);//これがないとo1,o12,o2が入り処理が長くなる
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        
        $fields = array('upload_data_id','modelname_id','filepath',1,$selectMetrics);     
        $data = $this->find('all',array('fields' => $fields,'conditions' => $conditions,'recursive'=>-1));       
        return $this->getOriginCity2Imple($data,$selectMetrics);
    }
    
    function getOriginCity2Imple($allData,$selectMetrics) 
    {	
    // 0L"(1) フォルダ／ファイル名",
	// 1L"(2) 由来(1 - 7 = 2,12,1,13,123,23,3)",
	// 2L"(3) 未使用",
	// 3L"(4) 欠陥の数",
	// 4L"(5) 物理行数",
    // 5L"(25) 手を加えた組織の数",
        $ids = array();
        foreach ($allData as $line)
        {
            $id = $line['Graph']['upload_data_id'];
            if(!in_array($id, $ids))
                $ids[]=$id;
        }

        $newAllData = array();
        foreach ($ids as $id) 
        {
            $tmpAllData = array_filter($allData, function($v)use($id) {return $v['Graph']['upload_data_id']==$id;});
            $data = array();//origin=>全レイヤーのメトリクスの合計・layer=>そのレイヤーのメトリクスの合計
            for($i = 1;$i<=7;++$i)
            {
                $layers = array('numOfFiles'=>0,'height'=>0,'layerHeight'=>array(0,0,0,0,0,0,0));
                $dataByOrigin = array_filter($tmpAllData, function($v)use($i) {return $v['Graph'][1]==$i;});
                foreach ($dataByOrigin as $line) 
                {
                    $metrics = $this->getMetricsValue($line['Graph'],$selectMetrics);
                    $layer =  $this->getLayer($line['Graph']['filepath']);
                    ++$layers['numOfFiles'];
                    $layers['layerHeight'][$layer]+=$metrics;
                }
                $data[$i] = $layers;
            }
        
            $sumOfValue=0;
            for($i = 1;$i<=7;++$i)
            {
                $height = 0;
                for($j = 0;$j<=6;++$j)
                {
                    $height += $data[$i]['layerHeight'][$j];
                }
                $data[$i]['height']=$height;
                $sumOfValue += $height;
            }
            if($sumOfValue==0)
                $data[0]=0;
            $newAllData[$id] = $data;
        }
        return $newAllData;
    }
}
