<?php 
    echo $this->element('formCreate');
    echo $this->element('seceletCSVid', array("formname" => 'CSV_ID',"isAllowEmpty" => false));
    echo $this->element('selectGroup',$groupName); 
    echo $this->element('setButton'); 

    if(isset($useLocalCSV))
    {
    ?><br><?php
    echo $this->Form->input('モデル名(ローカルファイル)', array('placeholder' => 'Local Model Name'));
    echo $this->Form->file('選択ファイル');//ファイル選択
	}
    echo $this->Form->end();
?>