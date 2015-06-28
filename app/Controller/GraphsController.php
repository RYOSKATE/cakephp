<?php
class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public $uses = array('Graph','GroupData','ModelName','GroupName');
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
        //    echo '<pre>';
        //     print_r($this->Auth->user());
        //     die();
        // echo '<pre>';
    }

    /*public function view($id) 
    {
        if (!$id) 
        {
            throw new NotFoundException(__('Invalid post'));
        }

    }*/
    function getDay($day)
    {
        $now = time();
        return mktime(date("H",$now),date("i",$now),date("s",$now),date("m",$now),date("d",$now)+$day,date("Y",$now));
    }
    public function alldevgroup() 
    {
        $groupNameData = $this->setGroupName();
        $modelNameData = $this->setModelName();
        $selectGroupName = reset($groupNameData);
        $selectModelName = reset($modelNameData);
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        if ($this->request->is('post')) 
        {
            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル']];
        }
        
        //最新のデータを取得する
        $data=array();
        for($i = 0;!$data&&-100*365<$i;--$i)//とりえあず100年をチェック範囲
        {
            $time = date('Y-m-d',$this->getDay($i));
            $conditions = array('conditions' => array('GroupData.model' => $selectModelName,'GroupData.date =' => '2015-06-26'/*,'GroupData.group_name' => $selectGroupName*/));
            $data = $this->GroupData->find('all',$conditions);
        echo '<pre>';
            print_r($time);
        echo '</pre>';
        }

        $this->set('data',$data);
    }
    
    public function onedevgroup() 
    {
        $groupNameData = $this->setGroupName();
        $modelNameData = $this->setModelName();

        $selectGroupName = reset($groupNameData);
        $selectModelName = array('dummy',reset($modelNameData),reset($modelNameData),reset($modelNameData),reset($modelNameData));
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        if (!empty($this->data)) 
        {    
            for($i=1;$i<count($selectModelName);++$i)
            {
                $selectModelName[$i] = $modelNameData[$this->data['Graph'] ['モデル'.$i]];
            }
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];         
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
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();

        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $selectModelName = reset($modelNameData);

        if ($this->request->is('post')) 
        {    
            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
        }

        $tree = $this->Graph->getFileMetricsTable($selectModelName,$selectGroupName);

        $this->set('tree',$tree);
        $this->set('depth',$this->Graph->getDepth());
    }

    public function origin()
    {
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();

        $selectGroupName = reset($groupNameData);//ALLは0に追加されている
        $selectModelName1 = reset($modelNameData);
        $selectModelName2 = reset($modelNameData);
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        if ($this->request->is('post')) 
        {    

            $selectModelName1 = $modelNameData[$this->data['Graph'] ['モデル1']];
            $selectModelName2 = $modelNameData[$this->data['Graph'] ['モデル2']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
        }

        $this->set('model1',$this->Graph->getOriginTable($selectModelName1,$selectGroupName));
        $this->set('model2',$this->Graph->getOriginTable($selectModelName2,$selectGroupName));
        $this->set('leftModelName',$selectModelName1);
        $this->set('rightModelName',$selectModelName2);
    }

    public function metrics()
    {
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();

        $selectGroupName = reset($groupNameData);
        $selectModelName1 = reset($modelNameData);
        $selectModelName2 = reset($modelNameData);

        if ($this->request->is('post')) 
        {    
            $selectModelName1 = $modelNameData[$this->data['Graph'] ['モデル1']];
            $selectModelName2 = $modelNameData[$this->data['Graph'] ['モデル2']];
            $selectGroupName =  $groupNameData[$this->data['Graph'] ['開発グループ']];
        }

        $data1 = $this->Graph->getCompareMetricsTable($selectModelName1,$selectGroupName);
        $data2 = $this->Graph->getCompareMetricsTable($selectModelName2,$selectGroupName);

        $this->set('data1',$data1);
        $this->set('data2',$data2);
        $this->set('name1',$selectModelName1);
        $this->set('name2',$selectModelName2);
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
