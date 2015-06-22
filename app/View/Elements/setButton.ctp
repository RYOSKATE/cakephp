<?php 
	echo $this->Form->input('セット', array
    (
    	'label'=>false,
    	'type'=>'submit',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control'
    ));
?> 