<?php 
	echo $this->Form->input('表示を更新', array
    (
    	'label'=>false,
    	'name'=>'set',
    	'type'=>'submit',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control'
    ));
?> 