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
    echo $this->element('selectModel',$modelName);
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