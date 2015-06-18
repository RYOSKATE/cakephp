<?php
class ModelName extends AppModel 
{
    public $useTable = 'model_names';
    function uploadFromCSV($selectModelName,$id)
    {

    // php.iniの変更点
    // upload_max_filesize=32M  8万行のデータで約10MB
    // memory_limit=1024M       8万行のデータを以下の$ret[] に格納するのに約256MB
    // post_max_size=64M        8万行のデータを(ry
    // max_execution_time=180   8万行のデータをローカルサーバのデータベースにアップロードするのに約60秒かかった
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
           
            $data = array('id'=>$id,'name'=> $selectModelName);

            if (!$this->saveAll($data)) 
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
