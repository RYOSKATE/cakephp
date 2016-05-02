<?php
class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

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
        if($uploadList)
        {        
            $selectGroupName = reset($groupNameData);
            $selectUploadDataId = $this->getFirstKey($uploadList);
            $data=[];//nullだとページ切替時枠が描画されない
            if (isset($this->request->data['set'])) 
            {
                $selectUploadDataId = $this->data['Graph']['CSV_ID'];
                $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
                $data = $this->Graph->getGroupData($selectGroupName, $selectUploadDataId);
            }
            $this->set('data',$data);
        }
    }
    
    public function onedevgroup() 
    {
        $this->operateSticky();
        $uploadList = $this->setUploadList();
        $groupNameData = $this->setGroupName();
        $modelNameData = $this->setModelName();
        $selectGroupName = reset($groupNameData);
        if ($uploadList && isset($this->request->data['set'])) 
        {
            $id = $this->getFirstKey($modelNameData);
            $name = $modelNameData[$id];
            $selectModelId = array($id,$id,$id,$id,$id);
            $selectModelName = array($name,$name,$name,$name,$name);
            for($i=1;$i<count($selectModelName);++$i)
            {
                $selectModelId[$i] = $this->data['Graph']['モデル'.$i];
                $selectModelName[$i] = $modelNameData[$selectModelId[$i]];
            }
            $selectGroupName = $groupNameData[$this->data['Graph']['開発グループ']];         
            for($i=1;$i<count($selectModelName);++$i)
            {
                //モデル名Aのidのデータのidを全て取得
                $dataIdByModel = $this->UploadData->find('list', array('fields' => array('date'),'conditions' => array('modelname_id' => $selectModelId[$i])));
                $data  = array();
                foreach($dataIdByModel as $id=>$date)
                {
                    $groupdata = $this->Graph->getGroupData($selectGroupName, $id)[0];
                    $groupdata['date'] = $date;
                    $data[] = $groupdata;
                }
                $this->set('data'.$i,$data);
            }
            $this->set('model',$selectModelName);
        }
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
        $selectMetrics = $this->getFirstKey($metricsListData);//未使用
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
        $selectMetrics = null;
        
        $selectModelName = null;
        $data=null;
        if ($uploadList && isset($this->request->data['set'])) 
        {
            $selectUploadDataId = $this->data['Graph']['CSV_ID'];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
            $selectMetrics = $this->data['Graph'] ['Metrics'];
            $data = $this->Graph->getOriginCity2($selectUploadDataId,$selectGroupName,$selectMetrics);
            $selectModelName = $uploadList[$selectUploadDataId];
        }
        $this->set('selectModelName',$selectModelName);
        if(0<$selectMetrics)
            $this->set('selectMetricsName',$metricsListData[$selectMetrics]);
        else
            $this->set('selectMetricsName',"");
        $this->set('selectMetrics',$selectMetrics);
        $this->set('data',$data);        

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
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
        //すでに存在するモデル名一覧を取得
        $modelNames = $this->ModelName->find('list');
        //array_splice($modelNames,0,0,'');//先頭に空欄を追加
        $this->set('modelName',$modelNames);
        
        if (!empty($this->data)) 
        {

            $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
            $up_file = $this->data['Graph']['選択ファイル']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
            $fileName = $uploadfile.$this->data['Graph']['選択ファイル']['name'];//data_10_utf.csv
            //まずgraphテーブルに由来に3が含まれる全てのデータを送信する
            $success = is_uploaded_file($up_file);//C:\xampp\tmp\php7F8D.tmp
            if ($success)
            {
                //コンボボックスで選ばれたグループ名を取得
                $selectModelId = $this->data['Graph'] ['モデル名'];
                $newModelName = $this->data['Graph'] ['新規モデル名'];
                $selectModelName;
                if(empty($newModelName) && empty($selectModelId))
                {   //両方空
                    $this->Session->setFlash(__('モデル名が入力されていません<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
                    return;
                }
                else if(empty($selectModelId))
                {   //新規モデル名入力
                    $is = $this->ModelName->find('first', array('conditions' => array('name' => $newModelName)));
                    if(empty($is))
                    {
                        $selectModelId = $this->ModelName->addNewModelName($newModelName);
                    }
                    else 
                    {
                        $selectModelId = $is['ModelName']['id'];
                    }
                    $selectModelName = $newModelName;                    
                }
                else 
                {
                    //モデル名選択済み(新規入力は無視)
                    $selectModelName = $modelNames[$selectModelId];
                }

                move_uploaded_file($up_file, $fileName);
                $upload_date = $this->data['Graph']['date'];
                $comment = $this->data['Graph']['comment'];
                $user_id = $this->Auth->user('id');
                $upload_id = $this->UploadData->upload($comment,$upload_date,$selectModelId,$user_id);
                $success = (0<$upload_id);

                //まずCSVを全体をアップロードする
                if($success)
                {
                    $groupNames = $this->Graph->uploadFromCSV($fileName,$selectModelId,$upload_id);
                    $success = ($groupNames != null);
                    if($success)
                    {
                        if($success)
                        {   //最後にグループ名を追加する
                            $success = $this->GroupName->uploadFromCSV($groupNames);
                        }
                    }
                }
            }
            if($success)
            {
                $this->Session->setFlash(__(basename($fileName).'のデータをアップロードしました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
            }
            else
            {
                if($upload_id)
                {
                    $this->UploadData->delete($upload_id);
                    $this->Graph->deleteAll(array('upload_data_id' => $upload_id));
                }
                $this->Session->setFlash(__(basename($fileName).'アップロードに失敗しました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
            }
        
            //コピーされたcsv削除
            $file = new File($fileName);
            $file->delete();
        }
    }

}
