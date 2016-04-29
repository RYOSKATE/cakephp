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

    echo $this->Form->input('モデル1',array
    (
        'type'=>'select',
        'options'=>$modelName,
        'class' => 'form-control'
     ));
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