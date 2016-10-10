<?php 
    echo $this->element('formCreate');

    echo '<div class="row">';
        echo '<div class="col-md-6 col-sm-6">';
                echo $this->element('seceletCSVid', array("formname" => 'CSV_ID1',"isAllowEmpty" => false));
                if(isset($useLocalCSV))
                {
                    echo $this->element('localCSV',array("formname" => __('selectCSV1')));
                }
        echo '</div>';
        echo '<div class="col-md-6 col-sm-6">';
                echo $this->element('seceletCSVid', array("formname" => 'CSV_ID2',"isAllowEmpty" => false));
                if(isset($useLocalCSV))
                {
                    echo $this->element('localCSV',array("formname" => __('selectCSV2')));
                }            
        echo '</div>';
        echo '<div class="col-md-6 col-sm-6">';
        echo $this->element('selectGroup',$groupName);
        echo '</div>';
        echo '<div class="col-md-6 col-sm-6">';
        echo $this->element('setButton');
        echo '</div>';
        echo '<div class="col-sm-6 col-md-6 col-lg-6">';
        echo $this->element('changeGraphButton'); 
        echo '</div>';        
    echo '</div>';
    echo $this->Form->end();
?>