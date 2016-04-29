<?php
class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public $uses = array('Graph','GroupData','ModelName','GroupName','Sticky','UploadData');
    /*
    CSV入力      Graph
    メトリクス   
    由来比較     OriginChart
    */
    private function setModelName()
    {
        //すでに存在する開発グループ名一覧を取得
        $modelNameData = $this->ModelName->find('list', array('fields' => array( 'id', 'name')));
        $this->set('modelName',$modelNameData);

        return $modelNameData;
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
	
	private function setMetricsList2()
    {
        //すでに存在する開発グループ名一覧を取得
        $metricsList = array(
			"(1) ファイルパス",
			"(2) 由来",
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
        // ここで hasMany を削除してみます
        $this->setUploadList();
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();
        $selectGroupName = reset($groupNameData);
        $selectModelName = reset($modelNameData);

        $conditions = array('conditions' => array('GroupData.model' => $selectModelName));
        if (isset($this->request->data['set'])) 
        {        

            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
            $conditions['conditions']['GroupData.model'] = $selectModelName;
            if($selectGroupName!='ALL')
            {
                $conditions['conditions']['GroupData.group_name'] = $selectGroupName;
            }
        }

        //最新のデータを取得する
        $idArray = $this->GroupData->find('first', array("fields" => array("MAX(GroupData.date) as max_date"),"conditions"=>array('model'=>$selectModelName)));
        $day = reset($idArray)['max_date'];
        $conditions['conditions']['GroupData.date =']= $day;
        $data = $this->GroupData->find('all',$conditions);
        $this->set('time',$day);
        $this->set('data',$data);

    }
    
    public function onedevgroup() 
    {
        $this->operateSticky();
        $groupNameData = $this->setGroupName();
        $modelNameData = $this->setModelName();
        $selectGroupName = reset($groupNameData);
        $selectModelName = array('dummy',reset($modelNameData),reset($modelNameData),reset($modelNameData),reset($modelNameData));
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする。

        if (isset($this->request->data['set'])) 
        {    
            for($i=1;$i<count($selectModelName);++$i)
            {
                $selectModelName[$i] = $modelNameData[$this->data['Graph']['モデル'.$i]];
            }
            $selectGroupName = $groupNameData[$this->data['Graph']['開発グループ']];         
        }
        for($i=1;$i<count($selectModelName);++$i)
        {
            $data = $this->GroupData->find('all',array('conditions' => array('GroupData.model' => $selectModelName[$i],'GroupData.group_name' => $selectGroupName)));
            $this->set('data'.$i,$data);
        }
        $this->set('model',$selectModelName);
    }

    public function onedevgroup2() 
    {
        $this->operateSticky();
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();

        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $selectModelName = reset($modelNameData);
        $tree=null;
        if (isset($this->request->data['set']))
        {
            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
            if (!empty($this->data['Graph']['選択ファイル']['name'])) 
            {
                $uploadfile = APP."webroot\\files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                $up_file = $this->data['Graph']['選択ファイル']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $uploadfile.$this->data['Graph']['選択ファイル']['name'];//data_10_utf.csv
                move_uploaded_file($up_file, $fileName);
                $tree = $this->Graph->getFileMetricsTableFromCSV($fileName);
            }
        }
        if($tree==null)
        {
            $tree = $this->Graph->getFileMetricsTable($selectModelName,$selectGroupName);
        }

        $this->set('tree',$tree);
        $this->set('depth',$this->Graph->getDepth());

        $this->set('useLocalCSV',true);
    }

    public function origin()
    {
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        $this->operateSticky();
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();

        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $selectModelName1 = reset($modelNameData);
        $selectModelName2 = reset($modelNameData);
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        $data1=null;
        $data2=null;

        if (isset($this->request->data['set']))
        {
            $selectModelName1 = $modelNameData[$this->data['Graph'] ['モデル1']];
            $selectModelName2 = $modelNameData[$this->data['Graph'] ['モデル2']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
        
            if (!empty($this->data['Graph'] ['選択ファイル1']['name'])) 
            {

                $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                $up_file = $this->data['Graph']['選択ファイル1']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $uploadfile.$this->data['Graph']['選択ファイル1']['name'];//data_10_utf.csv
                move_uploaded_file($up_file, $fileName);
                $data1 = $this->Graph->getOriginTableFromCSV($fileName);
                $selectModelName1 = $this->data['Graph']['モデル名1(ローカルファイル)'];
                if(empty($selectModelName1))
                {
                    $selectModelName1 = "local model1";
                }
            }

            if (!empty($this->data['Graph'] ['選択ファイル2']['name'])) 
            {

                $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                $up_file = $this->data['Graph']['選択ファイル2']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $uploadfile.$this->data['Graph']['選択ファイル2']['name'];//data_10_utf.csv
                move_uploaded_file($up_file, $fileName);
                $data2 = $this->Graph->getOriginTableFromCSV($fileName);
                $selectModelName2 = $this->data['Graph']['モデル名2(ローカルファイル)'];
                if(empty($selectModelName2))
                {
                    $selectModelName2 = "local model2";
                }
            }
        }
        if($data1==null)
        {
            $data1 = $this->Graph->getOriginTable($selectModelName1,$selectGroupName);
        }
        if($data2==null)
        {
            $data2 = $this->Graph->getOriginTable($selectModelName2,$selectGroupName);
        }

        $this->set('model1',$data1);
        $this->set('model2',$data2);
        $this->set('leftModelName',$selectModelName1);
        $this->set('rightModelName',$selectModelName2);
        $this->set('useLocalCSV',true);
    }
    
    public function originCity()
    {
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        $this->operateSticky();
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();
		$metricsListData = $this->setMetricsList();
		
        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $selectModelName1 = reset($modelNameData);
        $selectModelName2 = reset($modelNameData);
		$selectMetrics = 2;//未使用
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        $data1=null;
        $data2=null;

        if (isset($this->request->data['set']))
        {
            $selectModelName1 = $modelNameData[$this->data['Graph'] ['モデル1']];
            $selectModelName2 = $modelNameData[$this->data['Graph'] ['モデル2']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
			$selectMetrics = $this->data['Graph'] ['Metrics'];

            if (!empty($this->data['Graph'] ['選択ファイル1']['name'])) 
            {

                $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                $up_file = $this->data['Graph']['選択ファイル1']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $uploadfile.$this->data['Graph']['選択ファイル1']['name'];//data_10_utf.csv
                move_uploaded_file($up_file, $fileName);
                $data1 = $this->Graph->getOriginCityFromCSV($fileName,$selectMetrics);
                $selectModelName1 = $this->data['Graph']['モデル名1(ローカルファイル)'];
                if(empty($selectModelName1))
                {
                    $selectModelName1 = "local model1";
                }
            }

            if (!empty($this->data['Graph'] ['選択ファイル2']['name'])) 
            {

                $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                $up_file = $this->data['Graph']['選択ファイル2']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $uploadfile.$this->data['Graph']['選択ファイル2']['name'];//data_10_utf.csv
                move_uploaded_file($up_file, $fileName);
                $data2 = $this->Graph->getOriginCityFromCSV($fileName,$selectMetrics);
                $selectModelName2 = $this->data['Graph']['モデル名2(ローカルファイル)'];
                if(empty($selectModelName2))
                {
                    $selectModelName2 = "local model2";
                }
            }
        }
        if($data1==null)
        {
            $data1 = $this->Graph->getOriginCity($selectModelName1,$selectGroupName,$selectMetrics);
        }
        if($data2==null)
        {
            $data2 = $this->Graph->getOriginCity($selectModelName2,$selectGroupName,$selectMetrics);
        }

        $this->set('model1',$data1);
        $this->set('model2',$data2);
        $this->set('leftModelName',$selectModelName1);
        $this->set('rightModelName',$selectModelName2);
		$this->set('selectMetrics',$selectMetrics);
		$this->set('selectMetricsStr',$metricsListData[$selectMetrics]);
        $this->set('useLocalCSV',true);
    }
    
    public function originCity2()
    {        
        $this->operateSticky();
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();
		$metricsListData = $this->setMetricsList2();
		
        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $selectModelName = reset($modelNameData);
        $selectMetrics = 2;
        $data = null;
        if (isset($this->request->data['set']))
        {
            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル1']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
			$selectMetrics = $this->data['Graph'] ['Metrics'];
            $data = $this->Graph->getOriginCity2($selectModelName,$selectGroupName,$selectMetrics);
        // echo '<pre>';
        //     foreach ($data as $key => $val)
        //     {
        //         if($val['numOfFiles'])
        //         {
        //             print_r($key);print_r('<br>');
        //             print_r($val);
        //         }
        //     }
        // echo '</pre>';
        // die();
        }
        $this->set('selectModelName',$selectModelName);
        $this->set('selectMetricsName',$metricsListData[$selectMetrics]);
        $this->set('selectMetrics',$selectMetrics);
        $this->set('data',$data);
    }
    
    public function metrics()
    {
        $this->operateSticky();
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();

        $selectGroupName = reset($groupNameData);
        $selectModelName1 = reset($modelNameData);
        $selectModelName2 = reset($modelNameData);
        
        $data1=null;
        $data2=null;

        if (isset($this->request->data['set']))
        {
            $selectModelName1 = $modelNameData[$this->data['Graph'] ['モデル1']];
            $selectModelName2 = $modelNameData[$this->data['Graph'] ['モデル2']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
        
            if (!empty($this->data['Graph'] ['選択ファイル1']['name'])) 
            {

                $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                $up_file = $this->data['Graph']['選択ファイル1']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $uploadfile.$this->data['Graph']['選択ファイル1']['name'];//data_10_utf.csv
                move_uploaded_file($up_file, $fileName);
                $data1 = $this->Graph->getCompareMetricsTableFromCSV($fileName);
                $selectModelName1 = $this->data['Graph']['モデル名1(ローカルファイル)'];
                if(empty($selectModelName1))
                {
                    $selectModelName1 = "local model1";
                }
            }

            if (!empty($this->data['Graph'] ['選択ファイル2']['name'])) 
            {

                $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
                $up_file = $this->data['Graph']['選択ファイル2']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
                $fileName = $uploadfile.$this->data['Graph']['選択ファイル2']['name'];//data_10_utf.csv
                move_uploaded_file($up_file, $fileName);
                $data2 = $this->Graph->getCompareMetricsTableFromCSV($fileName);
                $selectModelName2 = $this->data['Graph']['モデル名2(ローカルファイル)'];
                if(empty($selectModelName2))
                {
                    $selectModelName2 = "local model2";
                }
            }
        }
        if($data1==null)
        {
            $data1 = $this->Graph->getCompareMetricsTable($selectModelName1,$selectGroupName);
        }
        if($data2==null)
        {
            $data2 = $this->Graph->getCompareMetricsTable($selectModelName2,$selectGroupName);
        }

        $this->set('data1',$data1);
        $this->set('data2',$data2);
        $this->set('name1',$selectModelName1);
        $this->set('name2',$selectModelName2);
        $this->set('useLocalCSV',true);
    }

    public function upload()
    { 
        //すでに存在するモデル名一覧を取得
        $modelNameData = $this->ModelName->find('list', array('fields' => array( 'id', 'name')));
        array_splice($modelNameData,0,0,'');//先頭に空欄を追加
        $this->set('modelName',$modelNameData);
        if (!empty($this->data)) 
        {
// echo '<pre>';
// print_r($this->data['Graph']);
// echo '</pre>';
// die();
            //コンボボックスで選ばれたグループ名を取得
            $selectModelId = $this->data['Graph'] ['モデル名'];
            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル名']];
            if($selectModelId < 1)//空欄の場合はテキストフィールドをチェック、新規モデル名が入力されていれば採用
            {
                $selectModelName = $this->data['Graph'] ['新規モデル名'];
                if($selectModelName=='')
                {
                    $this->Session->setFlash(__('モデル名が入力されていません<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
                    return;
                }
                $selectModelId = $this->ModelName->uploadFromCSV($selectModelName);
            }
            $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など
            $up_file = $this->data['Graph']['選択ファイル']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
            $fileName = $uploadfile.$this->data['Graph']['選択ファイル']['name'];//data_10_utf.csv
            //まずgraphテーブルに由来に3が含まれる全てのデータを送信する
            $success = is_uploaded_file($up_file);//C:\xampp\tmp\php7F8D.tmp
            if ($success)
            {
                move_uploaded_file($up_file, $fileName);
                $upload_date = $this->data['Graph']['date'];
                $user_id = $this->Auth->user('id');
                $upload_id = $this->UploadData->upload($upload_date,$selectModelId,$user_id);
                $success = (0<$upload_id);
                //まずCSVを全体をアップロードする
                if($success)
                {
                    $csvData = $this->Graph->uploadFromCSV($fileName,$selectModelName,$upload_id);
                    $success = ($csvData != null);
                    if($success)
                    {   //次にgroup_dataに開発グループごとの欠陥数/ファイル数/行数/日付のデータを送信する。
                        //すでに存在する開発グループ名一覧を取得
                        $groupNameData = $this->GroupName->find('list', array('fields' => array( 'id', 'name')));
                        $groupNames = $this->GroupData->uploadFromCSV($csvData,$selectModelName,$this->data['Graph']['date']);
                        $success = ($csvData != null);
                        if($success)
                        {   //最後にグループ名を追加する
                            $success = $this->GroupName->uploadFromCSV($groupNames,$groupNameData);
                            // if($success)
                            // {  //最後にグループ名を追加する
                            //    if(!in_array($selectModelName,$modelNameData))
                            //    {
                            //         $success = $this->ModelName->uploadFromCSV($selectModelName,count($modelNameData));
                            //    }
                            // }
                        }
                    }
                }
            }
            if($success)
            {
                $this->Session->setFlash(__('データをアップロードしました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
            }
            else
            {
                $this->Session->setFlash(__('アップロードに失敗しました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
            }
        
            $file = new File($fileName);
            $file->delete();
        }
    }

}
