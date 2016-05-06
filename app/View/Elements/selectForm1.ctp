<?php 
    echo $this->element('formCreate');
    echo '<div class="row">';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $this->element('seceletCSVid', array("formname" => 'CSV_ID',"isAllowEmpty" => false));
    echo '</div>';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $this->element('localCSV',array("formname" => __('選択ファイル')));
    echo '</div>';    
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $this->element('selectGroup',$groupName);
    echo '</div>';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $this->element('selectMetrics',array("selectMetrics" => $selectMetrics,"metricsList" => $metricsList)); 
    echo '</div>';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $this->element('setButton'); 
    echo '</div>';
    if(isset($useLocalCSV))
    {
    ?><br><?php
    echo $this->Form->input(__('モデル名1(ローカルファイル)'), array('placeholder' => 'Local Model1 Name'));
    echo $this->Form->file(__('選択ファイル1'));//ファイル選択
    }
    echo '</div>';
    echo $this->Form->end();
?>