<?php 
    echo $this->Form->create('Graph', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'label' => false,//array('class' => 'control-label'),
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => 'well form-inline',
    'enctype' => 'multipart/form-data',
    )); 
    echo '<div class="row">';
    echo '<div class="col-md-6 col-sm-6">';
    echo $this->Form->input('モデル1',array
    (
        'type'=>'select',
        'options'=>$modelName,
        'class' => 'form-control'
     ));
     echo '</div>';
     echo '<div class="col-md-6 col-sm-6">';
    echo $this->Form->input('モデル2',array
    (
        'type'=>'select',
        'options'=>$modelName,
        'class' => 'form-control'
     ));echo '</div>';
    if(isset($useLocalCSV))
    {
    ?><br><?php
    echo '<div class="col-md-6 col-sm-6">';
    echo $this->Form->input('モデル名1(ローカルファイル)', array('placeholder' => 'Local Model1 Name'));
     echo '</div>';
     echo '<div class="col-md-6 col-sm-6">';    
    echo $this->Form->input('モデル名2(ローカルファイル)', array('placeholder' => 'Local Model2 Name'));
         echo '</div>';
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