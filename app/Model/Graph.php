<?php
class Graph extends AppModel 
{

    function uploadFromCSV($fileName) 
    {

    // php.iniの変更点
    // upload_max_filesize=32M  8万行のデータで約10MB
    // memory_limit=1024M       8万行のデータを以下の$ret[] に格納するのに約256MB
    // post_max_size=64M        8万行のデータを(ry
    // max_execution_time=180   8万行のデータをローカルサーバのデータベースにアップロードするのに約60秒かかった
        try
        {
            $this->begin();//トランザクション(永続的な接続処理の開始)
            setlocale( LC_ALL, 'ja_JP.UTF-8' );
        	$ret = array();
        	$buf = mb_convert_encoding(file_get_contents($fileName), "utf-8", "auto");//sjis-win''
        	$lines = str_getcsv($buf, "\r\n");
        	foreach ($lines as $line) 
            {
        		$ret[] = array('model'=>'model1') + str_getcsv($line);
        	}

            if (!$this->saveAll($ret)) 
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
        echo '<pre>';
            print_r($ret[0]);
        echo '</pre>';
        return true;
    }

}
