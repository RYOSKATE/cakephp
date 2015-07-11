<?php 
	echo $this->Form->input('セット', array
    (
    	'label'=>false,
    	'name'=>'set',
    	'type'=>'submit',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control'
    ));
?> 