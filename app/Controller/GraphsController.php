<?php
class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public $uses = array('Graph','GroupData','ModelName','GroupName','Sticky');
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
            //コンボボックスで選ばれたグループ名を取得
            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル名']];
            if($selectModelName=='')//空欄の場合はテキストフィールドをチェック、新規モデル名が入力されていれば採用
            {
                $selectModelName = $this->data['Graph'] ['新規モデル名'];
                if($selectModelName=='')
                {
                     $this->Session->setFlash(__('モデル名が入力されていません<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
                    return;
                }
            }

            $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など

            $up_file = $this->data['Graph']['選択ファイル']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
 
            $fileName = $uploadfile.$this->data['Graph']['選択ファイル']['name'];//data_10_utf.csv
            //まずgraphテーブルに由来に3が含まれる全てのデータを送信する
            $success = is_uploaded_file($up_file);//C:\xampp\tmp\php7F8D.tmp
            if ($success)
            {
                move_uploaded_file($up_file, $fileName);
                //まずCSVを全体をアップロードする
                if($success)
                {
                    $success = $this->Graph->uploadFromCSV($fileName,$selectModelName);
                    if($success)
                    {   //次にgroup_dataに開発グループごとの欠陥数/ファイル数/行数/日付のデータを送信する。
                        //すでに存在する開発グループ名一覧を取得
                        $groupNameData = $this->GroupName->find('list', array('fields' => array( 'id', 'name')));
                        $success = $this->GroupData->uploadFromCSV($fileName,$selectModelName,$this->data['Graph']['date']);
                        if($success)
                        {   //最後にグループ名を追加する
                            $success = $this->GroupName->uploadFromCSV($fileName,$groupNameData);
                            if($success)
                            {  //最後にグループ名を追加する
                               if(!in_array($selectModelName,$modelNameData))
                               {
                                    $success = $this->ModelName->uploadFromCSV($selectModelName,count($modelNameData));
                               }
                            }
                        }
                    }
                }
            }
            if($success)
                $this->Session->setFlash(__('データをアップロードしました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
            else
                $this->Session->setFlash(__('アップロードに失敗しました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
        }
    }

}
