<?php 
	echo $this->Form->input('表示を更新', array
    (
    	'label'=>"　",
    	'name'=>'set',
    	'type'=>'submit',
    	'onchange' => 'submit(this.form)',
		'style'=>"width:100%;",
    	'class' => 'form-control'
    ));
?> 