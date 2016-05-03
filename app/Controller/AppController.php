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

  public function beforeFilter() 
  {
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
    
  protected function rejectWithoutAdmin()
  {
      if(!$this->isUserRoleAdmin())
        $this->redirect(array('controller' => 'graphs', 'action' => 'index'));
  }
  protected function rejectReader()
  {
      if($this->isUserRole('reader'))
        $this->redirect(array('controller' => 'graphs', 'action' => 'index'));
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
    
        $this->set('uploadList',$uploadList);
// echo '<pre>';
// print_r($uploadList);
// echo '</pre>';
// die();
        return $uploadList;

    }
}
