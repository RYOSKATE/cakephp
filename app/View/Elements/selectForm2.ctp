<?php 
    echo $this->element('formCreate');

    echo '<div class="row">';
    echo '<div class="col-md-6 col-sm-6">';
    
    echo $this->element('seceletCSVid', array("formname" => 'CSV_ID1',"isAllowEmpty" => false));
    echo '</div>';
    echo '<div class="col-md-6 col-sm-6">';
    echo $this->element('seceletCSVid', array("formname" => 'CSV_ID2',"isAllowEmpty" => false));
    echo '</div>';
    if(isset($useLocalCSV))
    {
        echo '<br>';
        echo '<div class="col-md-6 col-sm-6">';
        echo $this->Form->file('選択ファイル1');//ファイル選択
        echo '</div>';
        echo '<div class="col-md-6 col-sm-6">';
        echo $this->Form->file('選択ファイル2');//ファイル選択
        echo '</div>';
    }
    
    echo '<div class="col-md-12 col-sm-12">';
    echo $this->element('selectGroup',$groupName);
    echo $this->element('setButton');
    echo '</div>';
    echo '</div>';
    echo $this->Form->end();

?>