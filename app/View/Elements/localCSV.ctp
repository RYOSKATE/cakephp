<?php 
	echo $this->Form->input($formname, array
        (
            'type' => 'file',
            'label'=>__('CSVファイル選択'),
            'style'=>"width:100%;",
            'class' => 'form-control',
        ));
?>