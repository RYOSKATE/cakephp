<?php

class Sticky extends AppModel 
{
    public $useTable = 'stickies';
    
    public $belongsTo = array(
            'User' => array(
                'className' => 'User',
                'foreignKey' => 'user_id',
            )
        );
        
    function getStickies($page)
    {
        $data = $this->find('all',array('conditions' => array('Sticky.page'=>$page)));

        for ($i = 0; $i < count($data); ++$i)
        {
            $data[$i]['Sticky']['username']=$data[$i]['User']['username'];
            $data[$i]=$data[$i]['Sticky'];
        }
        echo '<pre>';
            print_r($data);
        echo '</pre>';
        return $data;
    }

    function addSticky($page,$user_id,$formData)
    {
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            date_default_timezone_set('Asia/Tokyo');
            // $idArray = $this->find('first', array("fields" => "MAX(Sticky.id) as max_id"));
            // $id = reset($idArray)['max_id']+1;
            $text = str_replace("\r\n","<br>",$formData['textarea']);
            $data = array(
                //'id'=>$id,
                'user_id'=>$user_id,
                'text'=>mb_convert_encoding($text, "utf-8", "auto"),
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

    function editSticky($page,$user_id,$formData)
    {
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            date_default_timezone_set('Asia/Tokyo');
            // $id_data = $this->find('all', array('conditions' => array('id' => $formData['id'],'username'=>$username)));
            // if(empty($id_data))
            // {
            //     throw new Exception();
            // }
            $data = array(
                'id'=>$formData['id'],
                'user_id'=>$user_id,
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

    function deleteSticky($id)
    {
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            if(!$this->delete($id))
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
}
