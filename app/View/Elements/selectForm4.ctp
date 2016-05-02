<?php 
    echo $this->element('formCreate');
    echo $this->element('seceletCSVid', array("formname" => 'CSV_ID',"isAllowEmpty" => false));

    echo $this->element('selectGroup',$groupName);
	echo $this->element('setButton');
	echo $this->element('selectMetrics',array($metricsList,$selectMetrics));
    if(isset($useLocalCSV))
    {
    ?><br><?php
    echo $this->Form->input('モデル名1(ローカルファイル)', array('placeholder' => 'Local Model1 Name'));
    echo $this->Form->file('選択ファイル1');//ファイル選択
    }
    echo $this->Form->end();
?>