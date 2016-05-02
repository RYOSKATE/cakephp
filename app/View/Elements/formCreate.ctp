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
?> 