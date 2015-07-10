<?php
class Graph extends AppModel 
{

    ///////csvのアップロード用///////
    function uploadFromCSV($fileName,$modelname) 
    {

    // php.iniの変更点
    // upload_max_filesize=32M  8万行のデータで約10MB
    // memory_limit=1024M       8万行のデータを以下の$ret[] に格納するのに約256MB
    // post_max_size=64M        8万行のデータを(ry
    // max_execution_time=180   8万行のデータをローカルサーバのデータベースにアップロードするのに約60秒かかった
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            setlocale( LC_ALL, 'ja_JP.UTF-8' );
        	$ret = array();
        	$buf = mb_convert_encoding(file_get_contents($fileName), "utf-8", "auto");//sjis-win''
        	$lines = str_getcsv($buf, "\r\n");
        	foreach ($lines as $line) 
            {
                $col = str_getcsv($line);
                if(4<=$col[1])//由来o3,o13,o23,o123のみ
                {
        		  $ret[] = array('model'=>$modelname,'file_path'=>$col[0]) +$col;
                }
        	}
        // echo '<pre>';
        //     //print_r($ret[0]);
        // echo '</pre>';

            if (!$this->deleteAll(array('model' => $modelname))) 
            {
                throw new Exception();
            }

            if (!$this->saveAll($ret)) 
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
        // echo '<pre>';
        //     //print_r($ret[0]);
        // echo '</pre>';
        return true;
    }
    ///////csvのアップロード用///////

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
              $data[] = array('model'=>"localCSV",'file_path'=>$col[0]) +$col;
            }
        }
        $this->depth=0;
        //model名,レイヤー、全ファイル数、血管のあるファイル数、欠陥数
//data[0]=Array
        // (
        //     [Graph] => Array
        //         (
        //             [model] => testA
        //             [file_path] => vendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/ImsSenderRxr.java
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
            $filepath = $data[$i]['file_path'];
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
    function getFileMetricsTable($selectModelName,$selectGroupName) 
    {

        $conditions = array('Graph.model' => $selectModelName);

        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        $data = $this->find('all',array('Fields' => array('model','file_path','3','8','9','10','11','18'),'conditions' => $conditions));
        
        $this->depth=0;
        //model名,レイヤー、全ファイル数、血管のあるファイル数、欠陥数
//data[0]=Array
        // (
        //     [Graph] => Array
        //         (
        //             [model] => testA
        //             [file_path] => vendor/qcom/proprietary/telephony-apps/ims/src/com/qualcomm/ims/ImsSenderRxr.java
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
            $filepath = $data[$i]['Graph']['file_path'];
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
    function getCompareMetricsTable($selectModelName,$selectGroupName) 
    {
        $conditions = array('Graph.model' => $selectModelName);
        if($selectGroupName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGroupName);
        }
        $data = $this->find('all',array('Fields' => array('model','file_path','3'),'conditions' => $conditions));
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
            $filePath = $data[$i]['Graph']['file_path'];
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

        // if($layer == 6)
        // {

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
              $data[] = array('model'=>"localCSV",'file_path'=>$col[0]) +$col;
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
    function getOriginTable($selectModelName,$selectGroupName) 
    {
        $conditions = array('Graph.model' => $selectModelName);
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
}
