<?php
class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public $uses = array('Graph','GroupData','ModelName','GroupName','ModelLayer','OriginChart');//GraphとModelLayerという複数のモデルを利用する宣言
    /*
    CSV入力      Graph
    メトリクス   ModelLayer
    由来比較     OriginChart
    */
    //$groupNameに開発グループ名一覧をセットする
    public function setGroupName()
    {
        //すでに存在する開発グループ名一覧を取得
        $groupNameData = $this->GroupName->find('list', array('fields' => array( 'id', 'name')));
        $this->set('groupName',$groupNameData);
    }
    public function setModelName()
    {
        //すでに存在する開発グループ名一覧を取得
        $modelNameData = $this->ModelName->find('list', array('fields' => array( 'id', 'name')));
        $this->set('modelName',$modelNameData);
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
        $this->setGroupName();
        $this->setModelName();
        //開発グループテーブルを作成し、upload時に重複チェック→新規登録、id付きで、を実装後にそれらを取得しここで有効にする。
        //$data = $this->GroupData->find('list', array('conditions' => array('GroupData.group_name' => 'pending')));
        //$this->set('groupName',$data);
                echo '<pre>';
            //print_r($data);
        echo '</pre>';
    }

    public function alldevgroup() 
    {
        $this->setGroupName();
        $this->setModelName();
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        if ($this->request->is('post')) 
        {
            $selectModelName = $this->request->data['Graph']['addModelName'];//追加するモデル名がテキストフィールドに入力されていた場合。
            if($selectModelName==null)//ここの動作は未確認
            {
                $selectModelName = $modelNameData[$this->request->data['Graph']['modelName']];
            }
        }
        $conditions = array('conditions' => array('GroupData.model' => 'testA'));
        $data = $this->GroupData->find('all',$conditions);

        $this->set('testA',$data);
        echo '<pre>';
            //print_r($data);
        echo '</pre>';
    }

    public function origin()
    {
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        //$this->set('data',$this->OriginChart->find('all'));
        $data1 = $this->Graph->find('all',array('fields' => array('1','3'),'conditions' => array('model' => 'testA')));
        $data2 = $this->Graph->find('all',array('fields' => array('1','3'),'conditions' => array('model' => 'testB')));

        $this->set('model1',$this->OriginChart->getOriginTable($data1));
        $this->set('model2',$this->OriginChart->getOriginTable($data2));
    }

    public function metrics($model = NULL)
    {
        $conditions = array('conditions' => array('ModelLayer.model' => 'model1'));
        $data = $this->ModelLayer->find('all',$conditions);
        $this->set('data',$data);

        if($model !=NULL)
        {
            $conditions = array('conditions' => array('ModelLayer.model' => $model));
            $data2 = $this->ModelLayer->find('all',$conditions);
            $this->set('data2',$data2);
        }
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
                    $this->Session->setFlash(__('モデル名が入力されていません<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                    return;
                }
            }

            $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など

            $up_file = $this->data['Graph']['選択ファイル']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp
 
            $fileName = $uploadfile.$this->data['Graph']['選択ファイル']['name'];//data_10_utf.csv
            //まずgraphテーブルに由来に3が含まれる全てのデータを送信する
            if (is_uploaded_file($up_file))//C:\xampp\tmp\php7F8D.tmp
            {
                move_uploaded_file($up_file, $fileName);
                if($this->Graph->uploadFromCSV($fileName,$selectModelName))
                {
                    //次にgroup_dataに開発グループごとの欠陥数/ファイル数/行数/日付のデータを送信する。
                    //すでに存在する開発グループ名一覧を取得
                    $groupNameData = $this->GroupName->find('list', array('fields' => array( 'id', 'name')));
                    if($this->GroupData->uploadFromCSV($fileName,$selectModelName))
                    {
                        if($this->GroupName->uploadFromCSV($fileName,$groupNameData))
                            $this->Session->setFlash(__('データをアップロードしました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                        else
                            $this->Session->setFlash(__('アップロードに失敗しました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
                    }
                    else
                        $this->Session->setFlash(__('アップロードに失敗しました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
                }
                else
                  $this->Session->setFlash(__('アップロードに失敗しました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
                //$this->redirect(array('action'=>'index'));
            
            }
        }
    }

}
