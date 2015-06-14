<?php
class GraphsController extends AppController 
{    
    public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session');

    public $uses = array('Graph','GroupData','ModelLayer','OriginChart');//GraphとModelLayerという複数のモデルを利用する宣言
    /*
    CSV入力      Graph
    メトリクス   ModelLayer
    由来比較     OriginChart
    */
    public function index() {}

    /*public function view($id) 
    {
        if (!$id) 
        {
            throw new NotFoundException(__('Invalid post'));
        }

    }*/

    public function onedevgroup() {}

    public function alldevgroup() {}

    public function origin()
    {
        //origin_chartsテーブルからデータを全て取得し、変数$dataにセットする
        //$this->set('data',$this->OriginChart->find('all'));
        $data1 = $this->Graph->find('all',array('fields' => array('1','3'),'conditions' => array('model' => 'model1')));
        $data2 = $this->Graph->find('all',array('fields' => array('1','3'),'conditions' => array('model' => 'model2')));

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
        if (!empty($this->data)) 
        {
            $model = $this->Graph;

            $uploadfile = APP."webroot/files".DS;//C:\xampp\htdocs\cakephp\app\webroot/files\  など

            $up_file = $this->data['Graph']['result']['tmp_name'];//C:\xampp\tmp\php7F8D.tmp

            $fileName = $uploadfile.$this->data['Graph']['result']['name'];//data_10_utf.csv

            //まずgraphテーブルに由来に3が含まれる全てのデータを送信する
            if (is_uploaded_file($up_file))//C:\xampp\tmp\php7F8D.tmp
            {
                move_uploaded_file($up_file, $fileName);
                if($model->uploadFromCSV($fileName))
		          $this->Session->setFlash(__('データをアップロードしました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                else
                  $this->Session->setFlash(__('アップロードに失敗しました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
                //$this->redirect(array('action'=>'index'));
            
            }

            //次にgroup_dataに開発グループごとの欠陥数/ファイル数/行数/日付のデータを送信
            $model = $this->GroupData;

            if (is_uploaded_file($up_file))//C:\xampp\tmp\php7F8D.tmp
            {
                move_uploaded_file($up_file, $fileName);
                if($model->uploadFromCSV($fileName))
                  $this->Session->setFlash(__('データをアップロードしました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
                else
                  $this->Session->setFlash(__('アップロードに失敗しました<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
                //$this->redirect(array('action'=>'index'));
            
            }
        }
    }

}
