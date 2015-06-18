<?php
class GroupName extends AppModel 
{
    public $useTable = 'group_names';
    function uploadFromCSV($fileName,$groupNameData) 
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
                $col = str_getcsv($line);
                if(4<=$col[1])//由来o3,o13,o23,o123のみ
                {
        		  $ret[] = $col;
                }
        	}

            $group_array = array();
            for ($i = 0; $i< count($ret); ++$i) 
            {

                $names = explode(';',$ret[$i][25]);
                for ($j = 0; $j< count($names); ++$j) 
                {
                	$group_array[] = trim($names[$j]);//念のため両端の空白文字の削除
                }
            }
            $result = array_unique($group_array);
            sort($result);

 			$data = array();
            for ($i = 1; $i< count($result); ++$i) //何故か空白文字のグループ名が毎回追加されてしまうため1から
            {
                $data[] = array('id'=>$i,'name'=> $result[$i]);
            }

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
