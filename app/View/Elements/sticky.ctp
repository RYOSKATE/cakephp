

<?php 

if($userData['role']!='reader')
{

    echo $this->Form->create('Graph',array('inputDefaults' => 
                                        array('div' => 'form-group',),
                                        'class' => 'well form-inline')
                                        );
                                        ?>
                                        <fieldset>
        <legend>付箋</legend><?php 

    echo $this->Form->input('textarea', array
    (
    	'id'=> 'textarea',
    	'label'=>false,
    	'type'=>'textarea',
    	'class' => 'col-md-12 col-sm-12',
    	'value'=>'',
    ));
    echo $this->Form->input('color',array
	(
		'id'=>'color',
	    'type'=>'select',
	    'options'=>array('#FFFFFF' => '白','#C869FF' => '紫', '#6BCDFF' => '青', '#71FD5E' => '緑', '#FECA61' => '黄', '#FA6565' => '赤'),
	    'class' => 'form-control'
	 ));
   	echo $this->Form->input('id',array
	(
		'id'=> 'id',
	    'type'=>'number',
	    'class' => 'form-control',
	    'step'=>1,
	    'min'=>0,
	    'max'=>end($stickies)['id'],
	    'value'=>0,
	    // 'list'=>array(1,2,3),
	 ));
   	echo $this->Form->input('x',array
	(
		'id'=> 'left',
	    'type'=>'number',
	    'class' => 'form-control',
	    'step'=>1,
	    'min'=>0,
	    'value'=>350,
	    // 'list'=>array(1,2,3),
	 ));
   	echo $this->Form->input('y',array
	(
		'id'=> 'top',
	    'type'=>'number',
	    'class' => 'form-control',
	    'step'=>1,
	    'min'=>0,
	    'value'=>490,
	    // 'list'=>array(1,2,3),
	 ));
   	echo $this->Form->input('add', array
    (
    	'id'=> 'add',
    	'label'=>false,
    	'name'=>'add',
    	'type'=>'button',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control',
    	'value'=>'add',
    ));
    echo $this->Form->input('delete', array
    (
    	'id'=> 'delete',
    	'label'=>false,
    	'name'=>'delete',
    	'type'=>'button',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control',
    	'value'=>'delete',
    ));
    echo $this->Form->input('edit', array
    (
    	'id'=> 'edit',
    	'name'=>'edit',
    	'label'=>false,
    	'type'=>'button',
    	'onchange' => 'submit(this.form)',
    	'class' => 'form-control',
    	'value'=>'edit',
    ));
    echo $this->Form->end();
}
    ?>
 </fieldset>