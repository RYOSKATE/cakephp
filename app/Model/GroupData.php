<?php
class GroupData extends AppModel 
{
    public $useTable = 'group_data';
    function uploadFromCSV($fileName,$modelname,$dateData) 
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
        		  $ret[] = array('model'=>$modelname) +$col;
                }
        	}
            date_default_timezone_set('Asia/Tokyo');

            $group_array = array();
            for ($i = 0; $i< count($ret); ++$i) 
            {

                $names = explode(';',$ret[$i][25]);
                for ($j = 0; $j< count($names); ++$j) 
                {
                    if(!isset($group_array[$names[$j]]))
                    {
                        $group_array += array($names[$j]=>array('file_num'=>1,'defact_num'=>$ret[$i][3],'loc'=>$ret[$i][4]));
                    }
                    else
                    {
                        $group_array[$names[$j]]['file_num']   += 1;
                        $group_array[$names[$j]]['defact_num'] += $ret[$i][3];
                        $group_array[$names[$j]]['loc']        += $ret[$i][4];
                    }
                }
                
            }

            $idArray = $this->find('first', array("fields" => "MAX(GroupData.id) as max_id"));
            $id = reset($idArray)['max_id'];
            $time = date('Y-m-d', mktime(0, 0, 0,$dateData['month'], $dateData['day'],$dateData['year']));
            $data = array();
            foreach ($group_array as $key => $value)
            {
                $data[]      = array(
                                'id' => ++$id,
                                'model'=>$modelname,
                                'group_name' =>$key,
                                'file_num'   =>$value['file_num'],
                                'defact_num' =>$value['defact_num'],
                                'loc'        =>$value['loc'],
                                'date'       =>$time,
                                );
            }

            //本当は日付て削除したかったができなかった。(なぜか全データが削除されてしまう)
            //日付で取得はできるので取得したidで既にその日付のデータが存在すれば削除を行う

            $conditions = array('conditions' => array('GroupData.model' => $modelname,'GroupData.date =' => $time));
            $overlapData = $this->find('all',$conditions);
            $deleteDataID = array();
            for ($i = 0; $i< count($overlapData); ++$i)
            {
                $deleteDataID[] = $overlapData[$i]['GroupData']['id'];
            }

            if (!$this->deleteAll(array('GroupData.id' => $deleteDataID)))
            {
                throw new Exception();
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

    function getData()
    {
        // for($i = 0;!$data;--$i)
        // {
        //     $time = date('Y-m-d',$this->getDay($i));
        //     $conditions = array('conditions' => array('GroupData.model' => $selectModelName,'GroupData.date =' => $time/*,'GroupData.group_name' => $selectGroupName*/));
        //     $this->GroupData->deleteAll(array('GroupData.model' => $selectModelName,'GroupData.date =' => $time));
        //     $data = $this->GroupData->find('all',$conditions);
        // echo '<pre>';
        //     print_r($time);
        // echo '</pre>';
        // }
    }
}
