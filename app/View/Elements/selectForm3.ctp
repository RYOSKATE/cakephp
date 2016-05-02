<?php 
    echo $this->element('formCreate');
    
    echo $this->element('seceletCSVid', array("formname" => 'CSV_ID1',"isAllowEmpty" => false));
    echo $this->element('seceletCSVid', array("formname" => 'CSV_ID2',"isAllowEmpty" => false));

    echo $this->element('selectGroup',$groupName);
	echo $this->element('setButton');
	echo $this->element('selectMetrics',array($metricsList,$selectMetrics));
    if(isset($useLocalCSV))
    {
    ?><br><?php
    echo $this->Form->file('選択ファイル1');//ファイル選択
    echo $this->Form->file('選択ファイル2');//ファイル選択
    }
    echo $this->Form->end();

?>