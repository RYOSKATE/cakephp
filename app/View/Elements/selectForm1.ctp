<?php 
    echo $this->element('formCreate');
    echo '<div class="row">';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $this->element('seceletCSVid', array("formname" => 'CSV_ID',"isAllowEmpty" => false));
    echo '</div>';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $this->element('localCSV',array("formname" => __('selectCSV')));
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
    echo '</div>';
    echo $this->Form->end();
?>