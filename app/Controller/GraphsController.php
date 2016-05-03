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
    
    public function flashText($message,$isSuccess=true)
    {
        if($isSuccess)
            $this->Session->setFlash(__($message.'<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
        else
            $this->Session->setFlash(__($message.'<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
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
	private function setMetricsList()
    {
        //すでに存在する開発グループ名一覧を取得
        $metricsList = array(
			"(1) ファイル数",
			"(2) 欠陥ファイル数",
			"(3) 未使用",
			"(4) 欠陥の数",
			"(5) 物理行数",
			"(6) 一行に複数の宣言や文がある数",
			"(7) 継承木における深さ",
			"(8) 他クラスの関数を呼び出す関数の率",
			"(9) 呼び出す他クラスの関数の種類数",
			"(10) メソッドの凝集度の欠如(COM)",
			"(11) Pubic メソッド数",
			"(12) Pubic 属性数",
			"(13) 他ファイルから使用される自ファイルの外部結合グローバル変数の種類数",
			"(14) 他ファイルから使用される自ファイルの外部結合グローバル変数の種類数(OO)",
			"(15) 他ファイルの外部結合グローバル変数を使用する関数の種類数",
			"(16) 他ファイルの外部結合グローバル変数を使用する関数の種類数(OO)",
			"(17) ディレクトリ外部の外部結合グローバル変数を使用する自ディレクトリのファイルの種類数",
			"(18) ディレクトリ外部の外部結合グローバル変数を使用する自ディレクトリのファイルの種類数(OO)",
			"(19) 呼び出す他ファイルの関数の種類数",
			"(20) 使用する他ファイルの外部結合グローバル変数の種類数",
			"(21) 自ファイルの関数を呼び出す他ファイルの関数の種類数",
			"(22) 外部結合グローバル変数の定義数",
			"(23) 外部結合グローバル変数の定義数(OO)",
			"(24) 明示的に初期化していない静的記憶域期間のオブジェクト数",
			"(25) 手を加えた組織の数"
		);
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
        if($uploadList)
        {        
            $data=[];//nullだとページ切替時枠が描画されない
            if (isset($this->request->data['set'])) 
            {
                $selectUploadDataId = $this->data['Graph']['CSV_ID'];
                $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
                $selectMetrics = $this->data['Graph'] ['Metrics'];
                $data = $this->Graph->getGroupData($selectUploadDataId,$selectMetrics,$selectGroupName);
                $selectModelName = $uploadList[$selectUploadDataId];
            }
            $this->set('data',$data);
            $this->set('selectMetricsStr',$metricsListData[$selectMetrics]);
        }
        else
		    $this->set('selectMetricsStr',"");
        $this->set('name',$selectModelName);
        $this->set('selectMetrics',$selectMetrics);
    }
    
    public function onedevgroup() 
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupName();
        $modelNameData = $this->setModelName();
        $selectGroupName = reset($groupNameData);
        
        $metricsListData = $this->setMetricsList();
        $selectModelName = null;
        $selectMetrics = 3;
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
            
            $data = array_fill(1,  4, array());          
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
                        die();  
                    }
                }
                if(!$isDuplicate)
                {

                    //モデル名Aのidのデータのidを全て取得
                    $dataIdByModel = $this->UploadData->find('list', array('fields' => array('date'),'conditions' => array('modelname_id' => $selectModelId[$i])));
                    if(!$dataIdByModel)
                    {
                        $this->flashText($selectModelName[$i].'のデータが存在しません',false);
                    }
                    foreach($dataIdByModel as $id=>$date)
                    {
                        $groupDataO = $this->Graph->getGroupData($id,$selectMetrics,$selectGroupName);
                        if($groupDataO)
                            $groupdata = $this->Graph->getGroupData($id,$selectMetrics,$selectGroupName)[0];
                        else
                            $this->flashText('選択グループは'.$selectModelName[$i].'のデータが存在しません',false);

                        $groupdata['date'] = $date;
                        $data[$i][] = $groupdata;
                    }
                }
                $this->set('data'.$i,$data[$i]);
            }  
            $this->set('model',$selectModelName);
        }
        $this->set('selectMetrics',$selectMetrics);
    }

    public function onedevgroup2() 
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $tree=null;
        if($uploadList)
        {
            $selectUploadDataId = $this->getFirstKey($uploadList);
            $selectGroupName = reset($groupNameData);//ALLは0に追加されている
            if (isset($this->request->data['set']))
            {
                $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
                if (!empty($this->data['Graph']['選択ファイル']['name'])) 
                {
                    $uploadfile = APP."webroot\\files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                    $up_file = $this->data['Graph']['選択ファイル']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $uploadfile.$this->data['Graph']['選択ファイル']['name'];//data_10_utf.csv
                    move_uploaded_file($up_file, $fileName);
                    $tree = $this->Graph->getFileMetricsTableFromCSV($fileName);
                    $selectModelName = basename($fileName);
                }
                else 
                {
                    $selectUploadDataId = $this->data['Graph']['CSV_ID'];
                    $tree = $this->Graph->getFileMetricsTable($selectUploadDataId,$selectGroupName);
                }
            }

        }
        $this->set('tree',$tree);
        $this->set('depth',$this->Graph->getDepth());
        $this->set('useLocalCSV',true);
    }

    public function origin()
    {
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        for($i=1;$i<=2;++$i)
        {
            $selectModelName =  null;
            $data=null;
            if($uploadList)
            {
                $selectUploadDataId = $this->getFirstKey($uploadList);                
                if (isset($this->request->data['set']))
                {
                    if (!empty($this->data['Graph'] ['選択ファイル'.$i]['name'])) 
                    {
                        $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                        $up_file = $this->data['Graph']['選択ファイル'.$i]['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                        $fileName = $uploadfile.$this->data['Graph']['選択ファイル'.$i]['name'];//data_10_utf.csv
                        move_uploaded_file($up_file, $fileName);
                        $data = $this->Graph->getOriginTableFromCSV($fileName);
                        $selectModelName = basename($fileName);
                    }
                    else
                    {
                        $selectModelName = $uploadList[$selectUploadDataId];
                        $data = $this->Graph->getOriginTable($selectUploadDataId,$selectGroupName);
                    }
                }
            }
            $this->set('model'.$i,$data);
            $this->set('ModelName'.$i,$selectModelName);
        }
        $this->set('useLocalCSV',true);
    }
    
    public function originCity()
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $metricsListData = $this->setMetricsList();
        $selectMetrics = 3;
        for($i=1;$i<=2;++$i)
        {
            $selectModelName = null;
            $data=null;
            if ($uploadList && isset($this->request->data['set']))
            {
                $selectUploadDataId = $this->data['Graph']['CSV_ID'.$i];
                $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
                $selectMetrics = $this->data['Graph'] ['Metrics'];

                if (!empty($this->data['Graph'] ['選択ファイル'.$i]['name'])) 
                {
                    $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                    $up_file = $this->data['Graph']['選択ファイル1']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $uploadfile.$this->data['Graph']['選択ファイル1']['name'];//data_10_utf.csv
                    move_uploaded_file($up_file, $fileName);
                    $data = $this->Graph->getOriginCityFromCSV($fileName,$selectMetrics);
                    $selectModelName = basename($fileName);
                }
                else 
                {
                    $selectModelName = $uploadList[$selectUploadDataId];
                    $data = $this->Graph->getOriginCity($selectUploadDataId,$selectGroupName,$selectMetrics);
                }
            }

            $this->set('model'.$i,$data);
            $this->set('ModelName'.$i,$selectModelName);
        }
		$this->set('selectMetrics',$selectMetrics);
        if(0<$selectMetrics)
		    $this->set('selectMetricsStr',$metricsListData[$selectMetrics]);
        else
		    $this->set('selectMetricsStr',"");
        $this->set('useLocalCSV',true);

    }
    
    public function originCity2()
    { 
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $selectGroupName = reset($groupNameData);

        $metricsListData = $this->setMetricsList();
        $selectMetrics = 3;
        
        $selectModelName = null;
        $data=null;
        if ($uploadList && isset($this->request->data['set'])) 
        {
            $selectUploadDataId = $this->data['Graph']['CSV_ID'];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
            $selectMetrics = $this->data['Graph'] ['Metrics'];
            $data = $this->Graph->getOriginCity2($selectUploadDataId,$selectGroupName,$selectMetrics);
            $selectModelName = $uploadList[$selectUploadDataId];
            $this->set('selectMetricsName',$metricsListData[$selectMetrics]);
        }
        else
            $this->set('selectMetricsName',"");
        $this->set('selectModelName',$selectModelName);
        $this->set('selectMetrics',$selectMetrics);
        $this->set('data',$data);        
    }
    
    public function metrics()
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        for($i=1;$i<=2;++$i)
        {
            $selectModelName = null;
            $data=null;
            if ($uploadList && isset($this->request->data['set']))
            {
                $selectUploadDataId = $this->getFirstKey($uploadList);                
                $selectUploadDataId = $this->data['Graph']['CSV_ID'.$i];            
                $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
                if (!empty($this->data['Graph'] ['選択ファイル'.$i]['name'])) 
                {
                    $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                    $up_file = $this->data['Graph']['選択ファイル'.$i]['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                    $fileName = $uploadfile.$this->data['Graph']['選択ファイル'.$i]['name'];//data_10_utf.csv
                    move_uploaded_file($up_file, $fileName);
                    $data = $this->Graph->getCompareMetricsTableFromCSV($fileName);
                    $selectModelName = basename($fileName);
                }
                else
                {
                    $selectModelName = $uploadList[$selectUploadDataId];                
                    $data = $this->Graph->getCompareMetricsTable($selectUploadDataId,$selectGroupName);
                }
            }
            $this->set('data'.$i,$data);
            $this->set('name'.$i,$selectModelName);
        }
        $this->set('useLocalCSV',true);
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
        
        $error_message = '';//エラーメッセージ用文字列
        $upload_id = 0;//アップロード時のid
        if (!empty($this->data)) 
        {
            //ファイルパス等を取得
            $fileName = $this->data['Graph']['選択ファイル']['name'];//data_10_utf.csv
            $tmp_file_file = $this->data['Graph']['選択ファイル']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp(PHPスクリプト終了と同時に削除されます)
            if($fileName)
            {
                //モデル名(id)を取得・あるいは新規追加
                $selectModelId = $this->data['Graph'] ['モデル名'];
                $newModelName = $this->data['Graph'] ['新規モデル名'];
                
                //既存モデル名・新規モデル名のチェック
                if(!empty($newModelName) || !empty($selectModelId))
                {
                    
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
                            print_r($selectModelId);
                            $this->Session->setFlash(__($newModelName.'は既に登録されています。<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-dismissable'));
                        }
                    }
                    
                    if(!$this->UploadData->hasAny(array('UploadData.modelname_id'=>$selectModelId,'UploadData.date'=>$this->data['Graph']['date'])))
                    {
                        //UploadDataをDBに追加
                        $data = $this->data['Graph'];
                        $data['user_id'] = $this->Auth->user('id');
                        $data['modelname_id'] = $selectModelId;
                        $upload_id = $this->UploadData->upload($data);
                        if($upload_id)
                        {                                    
                            //CSVの内容をDBにアップロードする
                            $groupNames = $this->Graph->uploadFromCSV($tmp_file_file,$selectModelId,$upload_id);
                            if($groupNames != null)
                            {
                                //最後にグループ名を追加する
                                if($success = $this->GroupName->uploadFromCSV($groupNames))
                                {   
                                    $this->flashText(__( $fileName. 'のデータをアップロードしました。'));
                                }
                                else
                                    $error_message = 'グループ名の登録に失敗しました。';
                            }
                            else
                                $error_message = 'CSVデータの内容のアップロードに失敗しました。';
                        }
                        else
                            $error_message = $UploadData . 'の登録に失敗しました。';
                    }
                    else
                        $error_message = '同一のモデル名、日付のデータが既に存在します。';
                }
                else
                    $error_message = 'モデル名が入力されていません。';
            }
            else
                $error_message = 'CSVデータファイルが選択されていません。';
                
            if($error_message)
            {
                if($upload_id)
                {
                    //$upload_idが0出ない場合、アップロードされてしまったデータを削除しておく。
                    $this->UploadData->delete($upload_id);
                    $this->Graph->deleteAll(array('upload_data_id' => $upload_id));
                }
                $this->flashText($error_message.'<br>アップロード処理を中断しました。',false);
            }

        }
    }
}
