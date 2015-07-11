<?php
class Sticky extends AppModel 
{
    public $useTable = 'sticky';

    function getStickies($page)
    {

        $data = $this->find('all',array('conditions' => array('Sticky.page'=>$page)));
 
        for ($i = 0; $i < count($data); ++$i)
        {
            $data[$i]=$data[$i]['Sticky'];
        }
        return $data;
    }

    function addSticky($page,$username,$formData)
    {
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            date_default_timezone_set('Asia/Tokyo');
            $idArray = $this->find('first', array("fields" => "MAX(Sticky.id) as max_id"));
            $id = reset($idArray)['max_id']+1;
            $data = array(
                'id'=>$id,
                'username'=>$username,
                'text'=>$formData['textarea'],
                'page'=>$page,
                'color'=>$formData['color'],
                'time'=>date('Y-m-d H:i:s',time()),
                'left'=>$formData['x'],
                'top'=>$formData['y'],
                );
            if (!$this->save($data)) 
            {
                throw new Exception();
            }

            $this->commit();
        }
        catch(Exception $e) 
        {
            $this->rollback();
            return false;
        }
        return true;
    }

    function editSticky($page,$username,$formData)
    {
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            date_default_timezone_set('Asia/Tokyo');
            $id_data = $this->find('all', array('conditions' => array('id' => $formData['id'],'username'=>$username)));
            if(empty($id_data))
            {
                throw new Exception();
            }
            $data = array(
                'id'=>$formData['id'],
                'username'=>$username,
                'text'=>$formData['textarea'],
                'page'=>$page,
                'color'=>$formData['color'],
                'time'=>date('Y-m-d H:i:s',time()),
                'left'=>$formData['x'],
                'top'=>$formData['y'],
             );
            if (!$this->save($data)) 
            {
                throw new Exception();
            }

            $this->commit();
        }
        catch(Exception $e) 
        {
            $this->rollback();
            return false;
        }
        return true;
    }

    function deleteSticky($page,$username,$formData)
    {
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            $id = $formData['id'];
            $id_data = $this->find('all', array('conditions' => array('id' => $id,'username'=>$username)));
            if(empty($id_data))
            {
                throw new Exception();
            }
            if (0 < $id)
            {
                if(!$this->delete($id))
                {
                    throw new Exception();
                }
            }
            $this->commit();
        }
        catch(Exception $e) 
        {
            $this->rollback();
            return false;
        }
        return true;
    }
}
