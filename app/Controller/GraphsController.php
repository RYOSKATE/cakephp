<?php
class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public $uses = array('Graph','Metrics','FileMetrics','GroupData','ModelName','GroupName','ModelLayer','OriginChart');//GraphとModelLayerという複数のモデルを利用する宣言
    /*
    CSV入力      Graph
    メトリクス   ModelLayer
    由来比較     OriginChart
    */
    //$groupNameに開発グループ名一覧をセットする
    private function setGroupName()
    {
        //すでに存在する開発グループ名一覧を取得
        $groupNameData = $this->GroupName->find('list', array('fields' => array( 'id', 'name')));
        $this->set('groupName',$groupNameData);
        return $groupNameData;
    }
    private function setGroupNameWithAll()
    {
        //すでに存在する開発グループ名一覧を取得
        $groupNameData = array(0=>"ALL") + $this->GroupName->find('list', array('fields' => array( 'id', 'name')));
        $this->set('groupName',$groupNameData);
        return $groupNameData;
    }
    private function setModelName()
    {
        //すでに存在する開発グループ名一覧を取得
        $modelNameData = $this->ModelName->find('list', array('fields' => array( 'id', 'name')));
        $this->set('modelName',$modelNameData);
        return $modelNameData;
    }
    public function index()
    {
    }

    /*public function view($id) 
    {
        if (!$id) 
        {
            throw new NotFoundException(__('Invalid post'));
        }

    }*/

    public function onedevgroup() 
    {
        $groupNameData = $this->setGroupName();
        $modelNameData = $this->setModelName();

        $selectGroupName = $groupNameData[1];
        $selectModelName = array('dummy',$modelNameData[1],$modelNameData[1],$modelNameData[1],$modelNameData[1]);
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

        $selectGroupName = $groupNameData[1];
        $selectModelName = $modelNameData[1];

        if ($this->request->is('post')) 
        {    
            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル']];
            $selectGrouplName = $groupNameData[$this->data['Graph'] ['開発グループ']];
        }

        $conditions = array('Graph.model' => $selectModelName);
        if($selectGrouplName != 'ALL')
        {
            $conditions += array('Graph.25' => $selectGrouplName);
        }
        $data = $this->Graph->find('all',array('fields' => array('model','file_path','3','8','9','18'),'conditions' => $conditions));
        $tree = $this->FileMetrics->getMetricsTable($data);
        
        $tree=json_encode($tree);

        $this->set('tree',$tree);
    }
    public function alldevgroup() 
    {
        $groupNameData = $this->setGroupName();
        $modelNameData = $this->setModelName();

        $selectGroupName = $groupNameData[1];
        $selectModelName = $modelNameData[1];
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        if ($this->request->is('post')) 
        {    
            $selectModelName = $modelNameData[$this->data['Graph'] ['モデル']];
        }
        $conditions = array('conditions' => array('GroupData.model' => $selectModelName/*,'GroupData.group_name' => $groupNameData[1]*/));
        $data = $this->GroupData->find('all',$conditions);

        $this->set('data',$data);
    }

    public function origin()
    {
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();

        $selectGroupName = $groupNameData[1];
        $selectModelName1 = $modelNameData[1];
        $selectModelName2 = $modelNameData[1];
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        if ($this->request->is('post')) 
        {    

            $selectModelName1 = $modelNameData[$this->data['Graph'] ['モデル1']];
            $selectModelName2 = $modelNameData[$this->data['Graph'] ['モデル2']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
        }

        $conditions1 = array('Graph.model' => $selectModelName1);
        $conditions2 = array('Graph.model' => $selectModelName2);
        if($selectGroupName != 'ALL')
        {
            $conditions1 += array('Graph.25' => $selectGroupName);
            $conditions2 += array('Graph.25' => $selectGroupName);
        }


        $data1 = $this->Graph->find('all',array('fields' => array('1','3'),'conditions' => $conditions1));
        $data2 = $this->Graph->find('all',array('fields' => array('1','3'),'conditions' => $conditions2));

        $this->set('model1',$this->OriginChart->getOriginTable($data1));
        $this->set('model2',$this->OriginChart->getOriginTable($data2));
        $this->set('leftModelName',$selectModelName1);
        $this->set('rightModelName',$selectModelName2);
    }

    public function metrics()
    {
        $groupNameData = $this->setGroupNameWithAll();
        $modelNameData = $this->setModelName();

        $selectGroupName = $groupNameData[1];
        $selectModelName1 = $modelNameData[1];
        $selectModelName2 = $modelNameData[1];

        if ($this->request->is('post')) 
        {    
            $selectModelName1 = $modelNameData[$this->data['Graph'] ['モデル1']];
            $selectModelName2 = $modelNameData[$this->data['Graph'] ['モデル2']];
            $selectGroupName = $groupNameData[$this->data['Graph'] ['開発グループ']];
        }
        $conditions1 = array('Graph.model' => $selectModelName1);
        $conditions2 = array('Graph.model' => $selectModelName2);
        if($selectGroupName != 'ALL')
        {
            $conditions1 += array('Graph.25' => $selectGroupName);
            $conditions2 += array('Graph.25' => $selectGroupName);
        }
        $data1 = $this->Graph->find('all',array('fields' => array('model','file_path','3'),'conditions' => $conditions1));
        $data2 = $this->Graph->find('all',array('fields' => array('model','file_path','3'),'conditions' => $conditions2));
    
        $data1 = $this->Metrics->getMetricsTable($data1);
        $data2 = $this->Metrics->getMetricsTable($data2);
// echo '<pre>';
//     print_r($data1);
// echo '</pre>';  
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
                        $success = $this->GroupData->uploadFromCSV($fileName,$selectModelName);
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
