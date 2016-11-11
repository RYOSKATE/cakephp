<?php
class TargetData
{
    public $csvName = null;//ローカルファイル名
    public $modelName = '';
    public $groupName = '';
    public $metricsName = '';//空文字を画面表示
    public $otherMethodName;

    public $csvId = null;//データベースのid
    public $modelId;
    public $groupId;
    public $metricsId = 3;
    public $otherMethodId;

    public $isLoadExternalCSV = false;
    public $data=[];//解析結果データ
    //nullだとページ切替時枠が描画されない
}

class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session','Paginator');

    public $uses = array('Graph','ModelName','GroupName','Sticky','UploadData');
    public $actions = array('alldevgroup','onedevgroup','onedevgroup2','metrics','origin','originCity','originCity2');

    /*
    CSV入力      Graph
    メトリクス   
    由来比較     OriginChart
    */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->setMethodList();
    }
    private function setModelName()
    {
        //すでに存在する開発グループ名一覧を取得
        $modelNameData = $this->ModelName->find('list');
        $this->set('modelName',$modelNameData);

        return $modelNameData;
    }
	
    private function getFirstKey($array)
    {
        return array_keys($array)[0];
    }
    private function setMethodList()
    {
        $methods = array(
            __('メトリクス散布図'),
			__('メトリクス遷移図'),
			__('メトリクスファイルマップ'),
			__('メトリクスレーダーチャート'),
			__('メトリクス円グラフ'),
			__('メトリクス領域図'),
			__('Origin City'),
        );
        if($this->getLang()=='eng')
        {
            $methods = array(
                __('Metrics Scatter Plot'),
                __('Metrics Transition'),
                __('Metrics File Map'),
                __('Metrics Radar Chart'),
                __('Metrics Pie Chart'),
                __('Metrics Area Figure'),
                __('Origin City'),
            );
        }
        $this->set('methods',$methods);
        return $methods;        
    }
	private function setMetricsList()
    {
        //すでに存在する開発グループ名一覧を取得
        $metricsList = array(
			__('(1) ファイル数'),
			__('(2) 欠陥ファイル数'),
			__('(3) 未使用'),
			__('(4) 欠陥の数'),
			__('(5) 物理行数'),
			__('(6) 一行に複数の宣言や文がある数'),
			__('(7) 継承木における深さ'),
			__('(8) 他クラスの関数を呼び出す関数の率'),
			__('(9) 呼び出す他クラスの関数の種類数'),
			__('(10) メソッドの凝集度の欠如(COM)'),
			__('(11) Pubic メソッド数'),
			__('(12) Pubic 属性数'),
			__('(13) 他ファイルから使用される自ファイルの外部結合グローバル変数の種類数'),
			__('(14) 他ファイルから使用される自ファイルの外部結合グローバル変数の種類数(OO)'),
			__('(15) 他ファイルの外部結合グローバル変数を使用する関数の種類数'),
			__('(16) 他ファイルの外部結合グローバル変数を使用する関数の種類数(OO)'),
			__('(17) ディレクトリ外部の外部結合グローバル変数を使用する自ディレクトリのファイルの種類数'),
			__('(18) ディレクトリ外部の外部結合グローバル変数を使用する自ディレクトリのファイルの種類数(OO)'),
			__('(19) 呼び出す他ファイルの関数の種類数'),
			__('(20) 使用する他ファイルの外部結合グローバル変数の種類数'),
			__('(21) 自ファイルの関数を呼び出す他ファイルの関数の種類数'),
			__('(22) 外部結合グローバル変数の定義数'),
			__('(23) 外部結合グローバル変数の定義数(OO)'),
			__('(24) 明示的に初期化していない静的記憶域期間のオブジェクト数'),
			__('(25) 手を加えた組織の数')
		);
        
        if($this->getLang()=='eng')
        {
            $metricsList = array(
                '(1) Number of files',
                '(2) Number of defects file',
                '(3) Unused',
                '(4) Number of defects',
                '(5) Lines of code',
                '(6) Number of multiple declarations or statements on one line',
                '(7) Depth of inheritance tree',
                '(8) Rate of the function that calls the function of the other class',
                '(9) Number of types of function calls other class',
                '(10) Lack of cohesion in methods',
                '(11) Number of public methods',
                '(12) Number of public fields',
                '(13) Number of types of outer join global variables used by other file',
                '(14) Number of types of outer join global variables used by other file(00)',
                '(15) Number of types of functions using outer join global variables in other file',
                '(16) Number of types of functions using outer join global variables in other file(00)',
                '(17) Number of types of files in own directory using outer join global variables in other directory',
                '(18) Number of types of files in own directory using outer join global variables in other directory(00)',
                '(19) Number of type of functions in other file',
                '(20) Number of types of outer join global variables in other file',
                '(21) Number of types of functions in in other file calling function in own file',
                '(22) Number of definition of outer join global variables',
                '(23) Number of definition of outer join global variables(00)',
                '(24) Number of explicitly uninitialized objects in static storage',
                '(25) Number of edited organization',
                );
        }
        $this->set('metricsList',$metricsList);
        return $metricsList;
    }
	
    public function index()
    {
        $this->operateSticky();
    }

    function getDay($day)
    {
        $now = time();
        return mktime(date("H",$now),date("i",$now),date("s",$now),date("m",$now),date("d",$now)+$day,date("Y",$now));
    }

    public function alldevgroup($formData=null)
    {
        $lastForm = $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $metricsListData = $this->setMetricsList();
        $target = new TargetData();
        if($formData != null)
        {
            $target = $formData[1];
            if ($target->isLoadExternalCSV)
            {
                $target->data = $this->Graph->getGroupDataFromCSV($target->csvName,$target->metricsId);
            }
            else
            {
                $target->data = $this->Graph->getGroupData($target->csvId,$target->metricsId,$target->groupName);
            }
        }
        else if (isset($this->request->data['set']) || isset($lastForm))
        {
            if($lastForm==null)
            {
                $lastForm = $this->data['Graph'];
            }
            $target->groupId = $lastForm ['開発グループ'];
            $target->groupName = $groupNameData[$target->groupId];
            $target->metricsId = $lastForm ['Metrics'];
            $target->metricsName = $metricsListData[$target->metricsId];

            if (!empty($lastForm ['selectCSV']['name']))
            {
                $target->csvName = $lastForm['selectCSV']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $lastForm['selectCSV']['name'];//data_10_utf.csv
                $target->csvName = basename($fileName);
                $target->isLoadExternalCSV = true;
            }
            else if(isset($lastForm['CSV_ID']))
            {                
                $target->csvId = $lastForm['CSV_ID'];
                $target->csvName = $uploadList[$target->csvId];
            }

            if($lastForm['可視化手法'] != null)
            {
                if($lastForm['可視化手法'] != 0)
                {
                    $target->otherMethodId = $lastForm['可視化手法'];
                    $target->otherMethodName = $this->actions[$target->otherMethodId];
                    $target->modelName = mb_substr($target->csvName,0,mb_strlen($target->csvName)-12);  
                    $target->modelId = array_search($target->modelName, $this->setModelName());
                    $temp = $lastForm;
                    $temp['可視化手法'] = null;
                    $lastForm =  $temp;
                    $this->setAction($target->otherMethodName, array_fill(1,4,$target));
                    return;
                }
            }
            if($target->isLoadExternalCSV)
            {
                $target->data = $this->Graph->getGroupDataFromCSV($target->csvName,$target->metricsId);
            }
            else
            {
                $target->data = $this->Graph->getGroupData($target->csvId,$target->metricsId,$target->groupName);
            }
        }
        $this->set('data',$target->data);
        $this->set('selectModelName', $target->csvName);
        $this->set('selectMetrics',$target->metricsId);
        $this->set('selectMetricsStr', $target->metricsName);
        $this->set('methodId',0);
    }
    
    public function onedevgroup($formData=null)
    {
        $lastForm = $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();        
        $metricsListData = $this->setMetricsList();

        $target[1] = new TargetData();
        $target[2] = new TargetData();
        $target[3] = new TargetData();
        $target[4] = new TargetData();
        foreach ($target as &$t)
        {
            $t->modelName = reset($groupNameData);
        }

        if ($uploadList && isset($this->request->data['set']) || $formData != null  || isset($lastForm)) 
        {
            if($lastForm==null)
            {
                $lastForm = $this->data['Graph'];
            }
            foreach ($target  as &$t)
            {
                $t->modelId = null;
                $t->modelName = null;
            }

            for($i=1; $i<=4; ++$i)
            {
                if(!isset($lastForm['モデル'.$i]) && $formData != null)
                {
                    $temp = $lastForm;
                    $temp['モデル'.$i] = $formData[$i]->modelId;
                    $temp['開発グループ'] = $formData[$i]->groupId;
                    $temp['Metrics'] = $formData[$i]->metricsId;
                    $this->data = $temp;
                }
                if($lastForm['モデル'.$i] != '')
                {
                    $target[$i]->modelId = $lastForm['モデル'.$i];
                    $target[$i]->modelName = $modelNameData[$target[$i]->modelId]; 
                }
                $target[$i]->groupId = $lastForm['開発グループ'];
                $target[$i]->groupName = $groupNameData[$target[$i]->groupId];

                $target[$i]->metricsId = $lastForm ['Metrics'];
                $target[$i]->metricsName = $metricsListData[$target[$i]->metricsId];
                $target[$i]->data = array();
            }
            $error_message = '';      
            for($i=1; $i<=4; ++$i)
            {
                if($formData != null)
                {
                    $target[$i] = $formData[$i];             
                }
                $isDuplicate  = false;
                for($j=1;$j<$i;++$j)
                {
                    if($target[$i]->metricsId == $target[$j]->metricsId)
                    {
                        $isDuplicate=true;
                        $target[$i]->data = $target[$j]->data;
                        break;
                    }
                }

                if(!$isDuplicate && $target[$i]->metricsId != null)
                {            
                    //モデル名Aのidのデータのidを全て取得
                    $dataIdByModel = $this->UploadData->find('list', array('fields' => array('date'),
                        'conditions' => array('modelname_id' => $target[$i]->modelId)));
                    if($dataIdByModel)
                    {
                        foreach($dataIdByModel as $id => $date)//モデルAの日付ごとのデータ
                        {
                            if($lastForm['可視化手法'] != null)
                            {                
                                $target[$i]->csvId = $id;                              
                                $target[$i]->csvName = $modelNameData[$target[$i]->modelId] . '(' . $date . ')';
                                $target[$i]->otherMethodId = $lastForm['可視化手法'];
                                $target[$i]->otherMethodName = $this->actions[$target[$i]->otherMethodId];
                            }
                            $groupData = $this->Graph->getGroupData($id,$target[1]->metricsId,$target[1]->groupName);
                            if(isset($groupData[0]))
                            {
                                $groupData = $groupData[0];
                                $groupData['date'] = $date;
                                $target[$i]->data[] = $groupData;
                            }
                        }
                    }
                    else 
                    {
                        $error_message .= $target[$i]->modelName.'のデータが存在しません<br>';
                    }
                }
                $this->set('data'.$i, $target[$i]->data);
            }
            if($lastForm['可視化手法'] != null)
            {
                if($lastForm['可視化手法'] != 1)
                {
                    $temp = $lastForm;
                    $temp['可視化手法'] = null;
                    $lastForm =  $temp;
                    $this->setAction($target[1]->otherMethodName,$target);
                    return;
                }
            }
            if($error_message!='')
            {
                $this->flashText($error_message, false);
            }
            $this->set('selectModelName',$target[1]->modelName);
        }
        $this->set('selectMetrics',$target[1]->metricsId);
        $this->set('selectMetricsStr', $target[1]->metricsName);
        $this->set('methodId',1);
    }

    public function onedevgroup2($formData=null)
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $metricsListData = $this->setMetricsList();

        $target = new TargetData();
        if($formData != null || isset($this->request->data['set']))
        {
            $chartMetrics = array();
            for ($i = 0; $i < count($metricsListData); ++$i)
            {
                if(isset($this->data['Graph']['Metrics' . $i]))
                {
                    $number = $this->data['Graph']['Metrics' . $i];
                    if(isset($metricsListData[$number]))
                    {
                        $chartMetrics[] = $number;
                    }
                }
            }

            $chartMetrics = array_unique($chartMetrics);
            sort($chartMetrics);
            $chartMetricsStr = array();
            
            foreach($chartMetrics as $metId)
            {
                $chartMetricsStr[] = $metricsListData[$metId];
            }
            $this->set('chartMetricsStr',$chartMetricsStr);
            $target->data = $chartMetrics;
        }

        if($formData != null)
        {
            $target = $formData[1];
            if ($target->isLoadExternalCSV)
            {
                $target->data = $this->Graph->getFileMetricsTableFromCSV($target->csvName, $target->metricsId, $target->data);
            }
            else
            {
                $target->data = $this->Graph->getFileMetricsTable($target->csvId,$target->groupName, $target->metricsId, $target->data);
            }
        }
        else if (isset($this->request->data['set']))
        {
            $target->groupId = $this->data['Graph'] ['開発グループ'];
            $target->groupName = $groupNameData[$target->groupId];
            $target->metricsId = $this->data['Graph'] ['Metrics'];
            $target->metricsName = $metricsListData[$target->metricsId];

            if (!empty($this->data['Graph'] ['selectCSV']['name']))
            {
                $target->csvName = $this->data['Graph']['selectCSV']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $this->data['Graph']['selectCSV']['name'];//data_10_utf.csv
                $target->csvName = basename($fileName);
                $target->isLoadExternalCSV = true;
            }
            else if(isset($this->data['Graph']['CSV_ID']))
            {                
                $target->csvId = $this->data['Graph']['CSV_ID'];
                $target->csvName = $uploadList[$target->csvId];
            }
            if($this->data['Graph']['可視化手法'] != null)
            {
                if($this->data['Graph']['可視化手法'] != 2)
                {
                    $target->otherMethodId = $this->data['Graph']['可視化手法'];
                    $target->otherMethodName = $this->actions[$target->otherMethodId];
                    $target->modelName = mb_substr($target->csvName,0,mb_strlen($target->csvName)-12);  
                    $target->modelId = array_search($target->modelName, $this->setModelName());
                    $temp = $this->data;
                    $temp['Graph']['可視化手法'] = null;
                    $this->data =  $temp;
                    $this->setAction($target->otherMethodName, array_fill(1,4,$target));
                    return;
                }
            }            

            if ($target->isLoadExternalCSV)
            {
                $target->data = $this->Graph->getFileMetricsTableFromCSV($target->csvName, $target->metricsId, $target->data);
            }
            else
            {
                $target->data = $this->Graph->getFileMetricsTable($target->csvId,$target->groupName, $target->metricsId, $target->data);
            }
        }
        $this->set('tree',$target->data);
        $this->set('depth',$this->Graph->getDepth());
        $this->set('selectModelName', $target->csvName);
        $this->set('selectMetrics',$target->metricsId);
        $this->set('selectMetricsStr', $target->metricsName);                            
        $this->set('useLocalCSV',true);
        $this->set('methodId',2);
    }
    
    public function metrics($formData=null)
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $metricsListData = $this->setMetricsList();
        $target[1] = new TargetData();
        $target[2] = new TargetData();
        
        if($formData != null)
        {
            for($i=1;$i<=2;++$i)
            {
                $target[$i] = $formData[$i];
                if ($target[$i]->isLoadExternalCSV)
                {
                    $target[$i]->data = $this->Graph->getCompareMetricsTableFromCSV($target[$i]->csvName,$target[$i]->metricsId);
                }
                else
                {
                    $target[$i]->data = $this->Graph->getCompareMetricsTable($target[$i]->csvId,$target[$i]->groupName,$target[$i]->metricsId);
                }
            }
        }
        else if (isset($this->request->data['set']))
        {
            for($i=1;$i<=2;++$i)
            {
                $target[$i]->groupId = $this->data['Graph'] ['開発グループ'];
                $target[$i]->groupName = $groupNameData[$target[$i]->groupId];
                $target[$i]->metricsId = $this->data['Graph'] ['Metrics'];
                $target[$i]->metricsName = $metricsListData[$target[$i]->metricsId];
                
                if (!empty($this->data['Graph'] ['selectCSV'.$i]['name'])) 
                {
                    $target[$i]->csvName = $this->data['Graph']['selectCSV'.$i]['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $this->data['Graph']['selectCSV'.$i]['name'];//data_10_utf.csv
                    $target[$i]->csvName = basename($fileName);
                    $target->isLoadExternalCSV = true;
                }
                else if(isset($this->data['Graph']['CSV_ID'.$i]))
                {
                    $target[$i]->csvId = $this->data['Graph']['CSV_ID'.$i];
                    $target[$i]->csvName = $uploadList[$target[$i]->csvId];          
                }
            }
            if($this->data['Graph']['可視化手法'] != null)
            {
                if($this->data['Graph']['可視化手法'] != 3)
                {
                    for($i=1;$i<=2;++$i)
                    {
                        $target[$i]->otherMethodId = $this->data['Graph']['可視化手法'];
                        $target[$i]->otherMethodName = $this->actions[$target[$i]->otherMethodId];
                        $target[$i]->modelName = mb_substr($target[$i]->csvName,0,mb_strlen($target[$i]->csvName)-12);  
                        $target[$i]->modelId = array_search($target[$i]->modelName, $this->setModelName());
                    }
                    $temp = $this->data;
                    $temp['Graph']['可視化手法'] = null;
                    $this->data =  $temp;               
                    $this->setAction($target[1]->otherMethodName, array(1=>$target[1],$target[2],$target[1],$target[2]));
                    return;
                }
            }
            for($i=1;$i<=2;++$i)
            {
                if($target[$i]->isLoadExternalCSV)
                {
                    $target[$i]->data = $this->Graph->getCompareMetricsTableFromCSV($target[$i]->csvName,$target[$i]->metricsId);
                }
                else
                {
                    
                    $target[$i]->data = $this->Graph->getCompareMetricsTable($target[$i]->csvId,$target[$i]->groupName,$target[$i]->metricsId);
                }                
            }
        }

        for($i=1;$i<=2;++$i)
        {
            $this->set('data'.$i,$target[$i]->data);
            $this->set('selectModelName'.$i,$target[$i]->csvName);
        }

        $this->set('useLocalCSV',true);
        $this->set('selectMetrics',$target[1]->metricsId);
        $this->set('selectMetricsStr',$target[1]->metricsName);
        $this->set('methodId',3);                            
    }
    
    public function origin($formData=null)
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $metricsListData = $this->setMetricsList();
        $target[1] = new TargetData();
        $target[2] = new TargetData();

        for($i=1;$i<=2;++$i)
        {
            $this->set('ModelName'.$i,null);
        }       
        if($formData != null)
        {
            for($i=1;$i<=2;++$i)
            {
                $target[$i] = $formData[$i];
                if ($target[$i]->isLoadExternalCSV)
                {
                    $target[$i]->data = $this->Graph->getOriginTableFromCSV($target[$i]->csvName,$target[$i]->metricsId);
                }
                else
                {
                    $target[$i]->data = $this->Graph->getOriginTable($target[$i]->csvId,$target[$i]->groupName,$target[$i]->metricsId);
                }
                $this->set('data'.$i,$target[$i]->data);
            }
        }
        else if (isset($this->request->data['set']))
        {
            for($i=1;$i<=2;++$i)
            {
                $target[$i]->groupId = $this->data['Graph'] ['開発グループ'];
                $target[$i]->groupName = $groupNameData[$target[$i]->groupId];
                $target[$i]->metricsId = $this->data['Graph'] ['Metrics'];
                $target[$i]->metricsName = $metricsListData[$target[$i]->metricsId];
                
                if (!empty($this->data['Graph'] ['selectCSV'.$i]['name'])) 
                {
                    $target[$i]->csvName = $this->data['Graph']['selectCSV'.$i]['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $this->data['Graph']['selectCSV'.$i]['name'];//data_10_utf.csv
                    $target[$i]->csvName = basename($fileName);
                    $target->isLoadExternalCSV = true;
                }
                else if(isset($this->data['Graph']['CSV_ID'.$i]))
                {
                    $target[$i]->csvId = $this->data['Graph']['CSV_ID'.$i];
                    $target[$i]->csvName = $uploadList[$target[$i]->csvId];          
                }
            }
            if($this->data['Graph']['可視化手法'] != null)
            {
                if($this->data['Graph']['可視化手法'] != 4)
                {
                    for($i=1;$i<=2;++$i)
                    {
                        $target[$i]->otherMethodId = $this->data['Graph']['可視化手法'];
                        $target[$i]->otherMethodName = $this->actions[$target[$i]->otherMethodId];
                        $target[$i]->modelName = mb_substr($target[$i]->csvName,0,mb_strlen($target[$i]->csvName)-12);  
                        $target[$i]->modelId = array_search($target[$i]->modelName, $this->setModelName());
                    }
                    $temp = $this->data;
                    $temp['Graph']['可視化手法'] = null;
                    $this->data =  $temp;               
                    $this->setAction($target[1]->otherMethodName, array(1=>$target[1],$target[2],$target[1],$target[2]));
                    return;
                }
            }
            for($i=1;$i<=2;++$i)
            {
                if ($target[$i]->isLoadExternalCSV)
                {
                    $target[$i]->data = $this->Graph->getOriginTableFromCSV($target[$i]->csvName,$target[$i]->metricsId);
                }
                else
                {
                    $target[$i]->data = $this->Graph->getOriginTable($target[$i]->csvId,$target[$i]->groupName,$target[$i]->metricsId);
                }
                $this->set('data'.$i,$target[$i]->data);
            }
        }

        for($i=1;$i<=2;++$i)
        {
            $this->set('ModelName'.$i,$target[$i]->csvName);
        }

        $this->set('useLocalCSV',true);
        $this->set('selectMetrics',$target[1]->metricsId);
        $this->set('selectMetricsStr',$target[1]->metricsName);
        $this->set('methodId',4);                           
    }
    
    public function originCity($formData=null)
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $metricsListData = $this->setMetricsList();
        $target[1] = new TargetData();
        $target[2] = new TargetData();
        for($i=1;$i<=2;++$i)
        {
            $this->set('ModelName'.$i,null);
            $target[$i]->data = null;
        }      
        if($formData != null)
        {
            for($i=1;$i<=2;++$i)
            {
                $target[$i] = $formData[$i];
                if ($target[$i]->isLoadExternalCSV)
                {
                    $target[$i]->data = $this->Graph->getOriginCityFromCSV($target[$i]->csvName,$target[$i]->metricsId);
                }
                else
                {
                    $target[$i]->data = $this->Graph->getOriginCity($target[$i]->csvId,$target[$i]->groupName,$target[$i]->metricsId);
                }
            }
        }
        else if (isset($this->request->data['set']))
        {
            for($i=1;$i<=2;++$i)
            {
                $target[$i]->groupId = $this->data['Graph'] ['開発グループ'];
                $target[$i]->groupName = $groupNameData[$target[$i]->groupId];
                $target[$i]->metricsId = $this->data['Graph'] ['Metrics'];
                $target[$i]->metricsName = $metricsListData[$target[$i]->metricsId];
                
                if (!empty($this->data['Graph'] ['selectCSV'.$i]['name'])) 
                {
                    $target[$i]->csvName = $this->data['Graph']['selectCSV'.$i]['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $this->data['Graph']['selectCSV'.$i]['name'];//data_10_utf.csv
                    $target[$i]->csvName = basename($fileName);
                    $target->isLoadExternalCSV = true;
                }
                else if(isset($this->data['Graph']['CSV_ID'.$i]))
                {
                    $target[$i]->csvId = $this->data['Graph']['CSV_ID'.$i];
                    $target[$i]->csvName = $uploadList[$target[$i]->csvId];          
                }
            }

            if($this->data['Graph']['可視化手法'] != null)
            {
                if($this->data['Graph']['可視化手法'] != 5)
                {
                    for($i=1;$i<=2;++$i)
                    {
                        $target[$i]->otherMethodId = $this->data['Graph']['可視化手法'];
                        $target[$i]->otherMethodName = $this->actions[$target[$i]->otherMethodId];
                        $target[$i]->modelName = mb_substr($target[$i]->csvName,0,mb_strlen($target[$i]->csvName)-12);  
                        $target[$i]->modelId = array_search($target[$i]->modelName, $this->setModelName());
                    }
                    $temp = $this->data;
                    $temp['Graph']['可視化手法'] = null;
                    $this->data =  $temp;               
                    $this->setAction($target[1]->otherMethodName, array(1=>$target[1],$target[2],$target[1],$target[2]));
                    return;
                }
            }

            for($i=1;$i<=2;++$i)
            {
                if ($target[$i]->isLoadExternalCSV)
                {
                    $target[$i]->data = $this->Graph->getOriginCityFromCSV($target[$i]->csvName,$target[$i]->metricsId);
                }
                else
                {
                    $target[$i]->data = $this->Graph->getOriginCity($target[$i]->csvId,$target[$i]->groupName,$target[$i]->metricsId);
                }
                for($d=0;$d<=7;++$d)
                {
                    //乱数でいい感じのMAFに
                    //$target[1]->data[$d] = rand(100,32676);
                }
                $this->set('data'.$i,$target[$i]->data);
            }
        }
        for($i=1;$i<=2;++$i)
        {
            $this->set('ModelName'.$i,$target[$i]->csvName);
            $this->set('data'.$i,$target[$i]->data);
        }

        $this->set('useLocalCSV',true);
        $this->set('selectMetrics',$target[1]->metricsId);
        $this->set('selectMetricsStr',$target[1]->metricsName);
        $this->set('methodId',5);
    }
    
    public function originCity2($formData = null)
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $metricsListData = $this->setMetricsList();
        $modelNameData = $this->setModelName();  
        $uploadIdList = null;
        $uploadDateList = null;
        $target = new TargetData();
        $target->data = null;
        if($formData != null)
        {
            $target = $formData[1];
            if ($target->isLoadExternalCSV)
            {
                $target->data = $this->Graph->getOriginCity2FromCSV($target->csvName,$target->metricsId);
            }
            else
            {
                $target->data = $this->Graph->getOriginCity2($target->modelId,$target->groupName,$target->metricsId);
            }
        }
        else if (isset($this->request->data['set']))
        {
            $target->groupId = $this->data['Graph'] ['開発グループ'];
            $target->groupName = $groupNameData[$target->groupId];
            $target->metricsId = $this->data['Graph'] ['Metrics'];
            $target->metricsName = $metricsListData[$target->metricsId];
            $target->modelId = $this->data['Graph']['selectModel'];
            $target->modelName = $modelNameData[$target->modelId];
            if (!empty($this->data['Graph'] ['selectCSV']['name']))
            {
                $target->csvName = $this->data['Graph']['selectCSV']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $this->data['Graph']['selectCSV']['name'];//data_10_utf.csv
                $target->csvName = basename($fileName);
                $target->isLoadExternalCSV = true;
            }
            // else if(isset($this->data['Graph']['CSV_ID']))
            // {                
            //     $target->csvId = $this->data['Graph']['CSV_ID'];
            //     $target->csvName = $uploadList[$target->csvId];
            // }

            if($this->data['Graph']['可視化手法'] != null)
            {
                if($this->data['Graph']['可視化手法'] != 6)
                {
                    $target->otherMethodId = $this->data['Graph']['可視化手法'];
                    $target->otherMethodName = $this->actions[$target->otherMethodId];
                    $temp = $this->data;
                    $temp['Graph']['可視化手法'] = null;
                    $this->data =  $temp;
                    $this->setAction($target->otherMethodName, array_fill(1,4,$target));
                    return;
                }
            }

            if ($target->isLoadExternalCSV)
            {
                $target->data = $this->Graph->getOriginCity2FromCSV($target->csvName,$target->metricsId);
            }
            else
            {
                $target->data = $this->Graph->getOriginCity2($target->modelId,$target->groupName,$target->metricsId);
            }

        }
        if($target->data != null)
        {            
            $selectModelDataList = $this->UploadData->find('list',array('fields' => array('date'),
                    'conditions' => array('modelname_id' => $target->modelId)));
                
            asort($selectModelDataList);

            $uploadIdList = array_keys($selectModelDataList);
            $uploadDateList = array_values($selectModelDataList);

            $target->modelName = $uploadList[$uploadIdList[0]];
        }

        $this->set('data',$target->data);
        $this->set('uploadList',$uploadList);
        $this->set('uploadIdList',$uploadIdList);
        $this->set('uploadDateList',$uploadDateList);
        $this->set('selectModelName', $target->modelName);
        $this->set('selectMetrics',$target->metricsId);
        $this->set('selectMetricsStr', $target->metricsName);
        $this->set('methodId',6);
    }

    public function upload()
    {
        $this->rejectReader();
        //すでに存在するモデル名一覧を取得
        $modelNames = $this->ModelName->find('list');
        $this->set('modelName',$modelNames);
        
        $uploadList = $this->setUploadList();
		$this->UploadData->recursive = 0;
        $this->Paginator->paginate();
		$this->set('uploadData', $this->requestAction('upload_data/index'));
        
        $message = '';//エラーメッセージ用文字列
        $upload_id = 0;//アップロード時のid
        
        if (!empty($this->data)) 
        {
            try
		    {
                $this->GroupName->begin();//複数Modelにまたがるトランザクション開始
                //ファイルパス等を取得
                $fileName = $this->data['Graph']['selectCSV']['name'];//data_10_utf.csv
                $tmp_file_file = $this->data['Graph']['selectCSV']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp(PHPスクリプト終了と同時に削除されます)
                if(empty($fileName))
                {
                    $message = __('CSVデータファイルが選択されていません。');
                    throw new Exception();
                }
                //モデル名(id)を取得・あるいは新規追加
                $selectModelId = $this->data['Graph'] ['モデル名'];
                $newModelName = $this->data['Graph'] ['新規モデル名'];
                
                //既存モデル名・新規モデル名のチェック
                if(empty($newModelName) && empty($selectModelId))
                {
                    $message = __('モデル名が入力されていません。');   
                    throw new Exception();
                }
     
                //新規モデル名入力時はDBに存在チェック、なければDBに追加。
                if(empty($selectModelId))
                {
                    if(!$this->ModelName->hasAny(array('ModelName.name'=>$newModelName)))
                    {
                        //DBに新規モデル名を追加。
                        $selectModelId = $this->ModelName->addNewModelName($newModelName);
                    }
                    else 
                    {
                        //既にDBにそのモデル名が存在していた場合。
                        $selectModelId = key($this->ModelName->find('list',array('conditions' => array('name' => $newModelName))));
                        $message .=$newModelName.'は既に登録されています。';
                    }
                }
                
                $date = $this->data['Graph']['date'];       
                if(isset($date['year']) && isset($date['year']) && isset($date['year']))
                    $date = $date['year'] . '-' . $date['month'] . '-' . $date['day'];
                if($this->UploadData->hasAny(array('UploadData.modelname_id'=>$selectModelId,'UploadData.date'=>$date)))
                {             
                    $message = __('同一のモデル名、日付のデータが既に存在します。');
                    throw new Exception();
                }
                
                //UploadDataをDBに追加
                $UploadData = array(
                    'date'=>$this->data['Graph']['date'],
                    'modelname_id'=>$selectModelId,
                    'user_id'=>$this->Auth->user('id'),
                    'comment'=>$this->data['Graph']['comment'],
                );
                $upload_id = $this->UploadData->upload($UploadData);
                if($upload_id==0)
                {                
                    $message = __('UploadDataの登録に失敗しました。');
                    throw new Exception();
                }
                        
                //CSVの内容をDBにアップロードする
                $groupNames = $this->Graph->uploadFromCSV($tmp_file_file,$selectModelId,$upload_id);
                if($groupNames == null)
                {
                    $message = __('CSVデータの内容のアップロードに失敗しました。');
                    throw new Exception();
                }
                
                //最後にグループ名を追加する
                $isCodeCheck = $this->data['Graph']['code_check'];
                $errorGroupNames = $this->GroupName->uploadFromCSV($groupNames,$isCodeCheck);
                
                if(!empty($errorGroupNames))
                {
                    $message = __('グループ名の登録に失敗しました。<br>');
                    if($errorGroupNames[0] != 'saveError')
                    {
                        foreach($errorGroupNames as $name)
                        {
                            $message .= '・' . $name . '<br>';
                        }
                        $message .= __('UTF-8で読み込めませんでした。CSVファイルの文字コードを確認してください。');                                        
                    }
                    throw new Exception();
                }
                
                $this->flashText(__( $fileName. 'のデータをアップロードしました。'));
                $this->Graph->commit();
            }
            catch(Exception $e) 
            {
                $this->flashText($message.'<br>アップロード処理を中断しました。',false);               
                $this->Graph->rollback();
            }
        }
    }
}