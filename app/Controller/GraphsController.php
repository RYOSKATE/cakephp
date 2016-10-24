<?php
class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session','Paginator');

    public $uses = array('Graph','ModelName','GroupName','Sticky','UploadData');
    /*
    CSV入力      Graph
    メトリクス   
    由来比較     OriginChart
    */
    
    private function setModelName()
    {
        //すでに存在する開発グループ名一覧を取得
        $modelNameData = $this->ModelName->find('list');
        $this->set('modelName',$modelNameData);

        return $modelNameData;
    }
	
    private function getFirstKey($array)
    {
        $temp = array_keys($array); 
        return $temp[0];
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
    public function alldevgroup() 
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $metricsListData = $this->setMetricsList();
        $selectModelName = null;
        $selectMetrics = 3;
        $selectMetricsStr = '';
     
        $data=array();//nullだとページ切替時枠が描画されない
        if (isset($this->request->data['set'])) 
        {
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
            $selectMetrics = $this->data['Graph'] ['Metrics'];
            $selectMetricsStr = $metricsListData[$selectMetrics];
            if (!empty($this->data['Graph'] ['selectCSV']['name'])) 
            {
                $up_file = $this->data['Graph']['selectCSV']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $this->data['Graph']['selectCSV']['name'];//data_10_utf.csv
                $data = $this->Graph->getGroupDataFromCSV($up_file,$selectMetrics);
                $selectModelName = basename($fileName);
            }
            else if(isset($this->data['Graph']['CSV_ID']))
            {                
                $selectUploadDataId = $this->data['Graph']['CSV_ID'];
                $data = $this->Graph->getGroupData($selectUploadDataId,$selectMetrics,$selectGroupName);
                $selectModelName = $uploadList[$selectUploadDataId];            
            }
        }
        $this->set('data',$data);
        $this->set('selectModelName',$selectModelName);
        $this->set('selectMetrics',$selectMetrics);
        $this->set('selectMetricsStr', $selectMetricsStr);
    }
    
    public function onedevgroup() 
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();
        $selectGroupName = reset($groupNameData);
        
        $metricsListData = $this->setMetricsList();
        $selectModelName = null;
        $selectMetrics = 3;
        $selectMetricsStr = '';
        if ($uploadList && isset($this->request->data['set'])) 
        {
            $selectModelId = array_fill(1,  4, null);
            $selectModelName = array_fill(1,  4, null);
            for($i=1;$i<=count($selectModelName);++$i)
            {
                if($this->data['Graph']['モデル'.$i] != '')
                {
                    $selectModelId[$i] = $this->data['Graph']['モデル'.$i];
                    $selectModelName[$i] = $modelNameData[$selectModelId[$i]];
                }
            }
       
            $selectGroupName = $groupNameData[$this->data['Graph']['開発グループ']];
            $selectMetrics = $this->data['Graph'] ['Metrics'];
            $selectMetricsStr = $metricsListData[$selectMetrics];
            $data = array_fill(1,  4, array());
            $error_message = '';      
            for($i=1;$i<=count($selectModelId);++$i)
            {
                $isDuplicate  = false;
                for($j=1;$j<$i;++$j)
                {
                    if($selectModelId[$i]==$selectModelId[$j])
                    {
                        $isDuplicate=true;
                        $data[$i] = $data[$j];
                        break;
                    }
                }
                if(!$isDuplicate && $selectModelId[$i]!=null)
                {
                    //モデル名Aのidのデータのidを全て取得
                    $dataIdByModel = $this->UploadData->find('list', array('fields' => array('date'),'conditions' => array('modelname_id' => $selectModelId[$i])));
                    if($dataIdByModel)
                    {
                        foreach($dataIdByModel as $id=>$date)//モデルAの日付ごとのデータ
                        {
                            $groupData = $this->Graph->getGroupData($id,$selectMetrics,$selectGroupName);
                            if(isset($groupData[0]))
                            {
                                $groupData=$groupData[0];
                                $groupData['date'] = $date;
                                $data[$i][] = $groupData;
                            }
                        }
                    }
                    else 
                    {
                        $error_message .= $selectModelName[$i].'のデータが存在しません<br>';
                    }
                }
                $this->set('data'.$i,$data[$i]);
            }  
            if($error_message!='')
            {
                $this->flashText($error_message,false);
            }

            $this->set('selectModelName',$selectModelName);
        }
        $this->set('selectMetrics',$selectMetrics);
        $this->set('selectMetricsStr', $selectMetricsStr);
    }

    public function onedevgroup2() 
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $tree=null;
        $metricsListData = $this->setMetricsList();
        $selectMetrics = 3;
        $selectMetricsStr = '';   
        $selectModelName = null;
        if (isset($this->request->data['set']))
        {
                $chartMetrics = array();
                for ($i = 0; $i < count($metricsListData); ++$i)
                {
                    $number = $this->data['Graph']['Metrics' . $i];
                    if(isset($metricsListData[$number]))
                        $chartMetrics[] = $number;
                }

                $chartMetrics = array_unique($chartMetrics);
                sort($chartMetrics);
                $chartMetricsStr = array();
                
                foreach($chartMetrics as $metId)
                {
                    $chartMetricsStr[] = $metricsListData[$metId];
                }
                $this->set('chartMetricsStr',$chartMetricsStr);
            
            $selectMetrics = $this->data['Graph'] ['Metrics']; 
            $selectMetricsStr = $metricsListData[$selectMetrics];
            if (!empty($this->data['Graph']['selectCSV']['name'])) 
            {
                $up_file = $this->data['Graph']['selectCSV']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $this->data['Graph']['selectCSV']['name'];//data_10_utf.csv
                $tree = $this->Graph->getFileMetricsTableFromCSV($up_file,$selectMetrics,$chartMetrics);
                $selectModelName = basename($fileName);
            }
            else  if(isset($this->data['Graph']['CSV_ID']))
            {
                $selectUploadDataId = $this->data['Graph']['CSV_ID'];
                $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
                $tree = $this->Graph->getFileMetricsTable($selectUploadDataId,$selectGroupName,$selectMetrics,$chartMetrics);
                $selectModelName = $uploadList[$selectUploadDataId];                            
            }
        }
        $this->set('tree',$tree);
        $this->set('depth',$this->Graph->getDepth());
        $this->set('selectModelName',$selectModelName);        
		$this->set('selectMetrics',$selectMetrics);
        $this->set('selectMetricsStr',$selectMetricsStr);                                
        $this->set('useLocalCSV',true);
    }
    
    public function metrics()
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $metricsListData = $this->setMetricsList();
        $selectMetrics = 3;
        $selectMetricsStr = '';
        $data=array();
        for($i=1;$i<=2;++$i)
        {
            $selectModelName = null;
            if (isset($this->request->data['set']))
            {
                $selectMetrics = $this->data['Graph']['Metrics'];
                $selectMetricsStr = $metricsListData[$selectMetrics];                    
                if (!empty($this->data['Graph'] ['selectCSV'.$i]['name'])) 
                {
                    $up_file = $this->data['Graph']['selectCSV'.$i]['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $this->data['Graph']['selectCSV'.$i]['name'];//data_10_utf.csv
                    $data = $this->Graph->getCompareMetricsTableFromCSV($up_file,$selectMetrics);
                    $selectModelName = basename($fileName);
                }
                else if(isset($this->data['Graph']['CSV_ID'.$i]))
                {
                    $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
                    $selectUploadDataId = $this->data['Graph']['CSV_ID'.$i]; 
                    $selectModelName = $uploadList[$selectUploadDataId];                
                    $data = $this->Graph->getCompareMetricsTable($selectUploadDataId,$selectGroupName,$selectMetrics);
                }
            }
            $this->set('data'.$i,$data);
            $this->set('selectModelName'.$i,$selectModelName);
        }
        $this->set('useLocalCSV',true);
        $this->set('selectMetrics',$selectMetrics);
        $this->set('selectMetricsStr',$selectMetricsStr);                                
    }
    
    public function origin()
    {
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $metricsListData = $this->setMetricsList();
        $selectMetrics = 3;
        $selectMetricsStr = '';
        $data=null;        
        for($i=1;$i<=2;++$i)
        {
            $selectModelName =  null;
            if (isset($this->request->data['set']))
            {
                $selectMetrics = $this->data['Graph'] ['Metrics'];
                $selectMetricsStr = $metricsListData[$selectMetrics];                                                            
                if (!empty($this->data['Graph'] ['selectCSV'.$i]['name'])) 
                {
                    $up_file = $this->data['Graph']['selectCSV'.$i]['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $this->data['Graph']['selectCSV'.$i]['name'];//data_10_utf.csv
                    $data = $this->Graph->getOriginTableFromCSV($up_file,$selectMetrics);
                    $selectModelName = basename($fileName);
                }
                else if(isset($this->data['Graph']['CSV_ID'.$i]))
                {
                    $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];                    
                    $selectUploadDataId = $this->data['Graph']['CSV_ID'.$i];              
                    $selectModelName = $uploadList[$selectUploadDataId];
                    $data = $this->Graph->getOriginTable($selectUploadDataId,$selectGroupName,$selectMetrics);
                }
            }
            $this->set('data'.$i,$data);            
            $this->set('ModelName'.$i,$selectModelName);
        }
        $this->set('useLocalCSV',true);
        $this->set('selectMetrics',$selectMetrics);
        $this->set('selectMetricsStr',$selectMetricsStr);                                        
    }
    
    public function originCity()
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $metricsListData = $this->setMetricsList();
        $selectMetrics = 3;
        $selectMetricsStr = '';
        $data=null;
        for($i=1;$i<=2;++$i)
        {
            $selectModelName = null;
            if (isset($this->request->data['set']))
            {
                $selectMetrics = $this->data['Graph'] ['Metrics'];
                $selectMetricsStr = $metricsListData[$selectMetrics];                                                              
                if (!empty($this->data['Graph'] ['selectCSV'.$i]['name'])) 
                {
                    $up_file = $this->data['Graph']['selectCSV'.$i]['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $this->data['Graph']['selectCSV'.$i]['name'];//data_10_utf.csv
                    $data = $this->Graph->getOriginCityFromCSV($up_file,$selectMetrics);
                    $selectModelName = basename($fileName);
                }
                else if(isset($this->data['Graph']['CSV_ID'.$i]))
                {
                    $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
                    $selectUploadDataId = $this->data['Graph']['CSV_ID'.$i]; 
                    $selectModelName = $uploadList[$selectUploadDataId];                
                    $data = $this->Graph->getOriginCity($selectUploadDataId,$selectGroupName,$selectMetrics);
                }
            }
            $this->set('data'.$i,$data);
            $this->set('ModelName'.$i,$selectModelName);
        }
        $this->set('useLocalCSV',true);
        $this->set('selectMetrics',$selectMetrics);
        $this->set('selectMetricsStr',$selectMetricsStr);     
    }
    
    public function originCity2()
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $modelNameData = $this->setModelName();
        $groupNameData = $this->setGroupNameWithAll();
        $metricsListData = $this->setMetricsList();
        $selectModelName = null;
        $selectMetrics = 3;
        $selectMetricsStr = '';
        $uploadIdList = null;
        $uploadDateList = null;

        $data=null;
        if (isset($this->request->data['set'])) 
        {
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
            $selectMetrics = $this->data['Graph'] ['Metrics'];
            $selectMetricsStr = $metricsListData[$selectMetrics];
            if (!empty($this->data['Graph'] ['selectCSV']['name'])) 
            {
                $up_file = $this->data['Graph']['selectCSV']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $this->data['Graph']['selectCSV']['name'];//data_10_utf.csv
                $data = $this->Graph->getOriginCity2FromCSV($up_file,$selectMetrics);
                $selectModelName = basename($fileName);
            }
            else if(isset($this->data['Graph']['selectModel']))
            {                
                $selectModelId = $this->data['Graph']['selectModel'];
                $data = $this->Graph->getOriginCity2($selectModelId,$selectGroupName,$selectMetrics);
                $selectModelDataList = $this->UploadData->find('list',array('fields' => array('date'),'conditions' => array('modelname_id' => $selectModelId)));
                
                asort($selectModelDataList);

                $uploadIdList = array_keys($selectModelDataList);
                $uploadDateList = array_values($selectModelDataList);

                $selectModelName = $uploadList[$uploadIdList[0]];
        // echo '<pre>';
        // print_r($selectModelId);
        // print_r($selectModelDataList);
        // print_r($uploadIdList);
        // print_r($uploadDateList);
        // print_r($uploadList);
        // echo '</pre>';
            }
        }
        
        $this->set('data',$data);
        $this->set('uploadList',$uploadList);
        $this->set('uploadIdList',$uploadIdList);
        $this->set('uploadDateList',$uploadDateList);
        $this->set('selectModelName',$selectModelName);
        $this->set('selectMetrics',$selectMetrics);
        $this->set('selectMetricsStr', $selectMetricsStr);    
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
