<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller 
{

   public $uses = array('GroupName','Sticky','UploadData');

   public $components = array
   (
    'Session',
    'Cookie',
    //'DebugKit.Toolbar',
    'Auth' => array(
                    'loginRedirect'  => array('controller' => 'graphs', 'action' => 'index'),
                    'logoutRedirect' => array('controller' => 'users', 'action'  => 'login'),
                    'flash'          => array(
                                              'element' => 'alert',
                                              'key'     => 'auth',
                                              'params'  => array(
                                                                  'plugin' => 'BoostCake',
                                                                  'class'  => 'alert-error'
                                                                ),
                                             ),
                  ),
  );

  public $helpers = array
  (
    'Session',
    'Html'      => array('className' => 'BoostCake.BoostCakeHtml'),
    'Form'      => array('className' => 'BoostCake.BoostCakeForm'),
    'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
  );

  public function flashText($message,$isSuccess=true)
  {
    if($isSuccess)
        $this->Session->setFlash(__($message.'<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-success alert-dismissable'));
    else
        $this->Session->setFlash(__($message.'<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));
  }
  
  public function getLang()
  {
		//全てに当てはまらなかった場合の初期値
		$lang = 'jpn';
    //表示言語を判別する。
	if (isset($this->params['named']['lang'])) {
		//URL中の"lang"パラメータ
		$lang = $this->params['named']['lang'];
	} elseif ($cookie = $this->Cookie->read('lang')) {
		//クッキー
		$lang = ($cookie == 'jpn')
			? 'jpn'
			: 'eng';
	} elseif (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		//ユーザのブラウザの言語設定
		$arr = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
		$arr = explode(';', $arr[0]);
		$lang = ($arr[0] == 'ja')
			? 'jpn'
			: 'eng';
	}
    return $lang;
  }
  private function setTextLocal()
  {
    
	$lang = $this->getLang();
	//CakePHPでの表示言語を指定。
	Configure::write('Config.language', $lang);
	//クッキーに言語情報を格納。
	$this->Cookie->write('lang', $lang, true, '30 Days');
  }
  public function beforeFilter() 
  {
      $this->setTextLocal();
      //サイズは3<=2<=1でなければならない -1は自動(無制限)
      ini_set('memory_limit', -1);//1.使用するメモリ量：CSVのアップロードで1GB以上
      ini_set('post_max_size', '64M');//2.CSVファイルが数十MB
      ini_set('upload_max_filesize', '64M');//3.CSVファイルが数十MB
      ini_set('max_execution_time', -1);//秒数：データベースにCSVファイルの内容を登録するのに数分
      //Configure AuthComponent
      $this->Auth->allow('display'); // Allows access to the homepage of the app
      $this->Auth->loginAction    = array('controller' => 'users' , 'action' => 'login');
      $this->Auth->logoutRedirect = array('controller' => 'users' , 'action' => 'login');
      $this->Auth->loginRedirect  = array('controller' => 'graphs', 'action' => 'index');
      $this->set('userData', $this->Auth->user());
  }
  
  protected function isUserRole($role)
  {
      return $this->Auth->user('role') ==$role;
  }
  
  protected function isUserRoleAdmin()
  {
      return $this->isUserRole('admin');
  }
  
  protected function rejectReader()
  {
      if($this->isUserRole('reader'))
      {
          $this->flashText(__('表示権限のないページにアクセスしようとしました。'),false);          	 
          $this->redirect(array('controller' => 'graphs', 'action' => 'edit'));
      }
  }
  protected function rejectNotAdmin()
  {
      if(!$this->isUserRoleAdmin())
      {
          $this->flashText(__('表示権限のないページにアクセスしようとしました。'),false);          	 
          $this->redirect(array('controller' => 'graphs', 'action' => 'edit'));
      }
  }

  public function beforeRender()
  {
    $this->set('stickies', $this->Sticky->getStickies($this->action));
  }

  protected function operateSticky()
  {
    if(!empty($this->data['Graph']))
    {
      $formData = $this->data['Graph'];
      $user_id = $this->Auth->user('id');


      if(isset($this->request->data['delete']))
      {
          $this->Sticky->deleteSticky($formData['id']);
      }
      else if (isset($formData['textarea']) && trim($formData['textarea'])!="") 
      {
          if(isset($this->request->data['add']))
          {
              $this->Sticky->addSticky($this->action,$user_id,$formData);  
          }
          else if(isset($this->request->data['edit']))
          {
              $this->Sticky->editSticky($this->action,$user_id,$formData);  
          }
      }
    }
  }
    //$groupNameに開発グループ名一覧をセットする
   protected function setGroupName($state=null)
   {
        //すでに存在する開発グループ名一覧を取得
        $groupNameData = $this->GroupName->find('list', array('fields' => array( 'id', 'name'),'order' => array('name ASC')));

        if($this->Auth->user('group')!='ALL' && $this->Auth->user('role')!='admin' && $state!='add')
        {
            $group = $this->Auth->user('group');
            $group = explode(',',$group);
            $groupNameData = array_intersect($groupNameData,$group);
        }
        $this->set('groupName',$groupNameData);
        return $groupNameData;
    }
    
    protected function setGroupNameWithAll($state=null)
    {
        //すでに存在する開発グループ名一覧を取得
        $groupNameData = array(0=>"ALL") + $this->setGroupName($state);
        $this->set('groupName',$groupNameData);
        return $groupNameData;
    }
    
    protected function setUploadList($state=null)
    {
        $this->UploadData->unbindModel(array('hasMany' => array('Graph')));
        $uploadList = $this->UploadData->find('list', array('fields' => array('date'),'order' => array('date DESC'), ));
        $uploadModelList = $this->UploadData->find('list', array('fields' => array('modelname_id')));
        $modelnameList = $this->ModelName->find('list');
        foreach($uploadList as $key => $value)
        {
            $uploadList[$key]=$modelnameList[$uploadModelList[$key]]."(".strval($value).")";
        }
        krsort($uploadList);
        $this->set('uploadList',$uploadList);
// echo '<pre>';
// print_r($uploadList);
// echo '</pre>';
// die();
        return $uploadList;

    }
}
