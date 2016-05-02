<div class="container">  
<div class="row">
<div class="col-md-8 col-md-offset-2">
<?php if($userData['role']=='admin' || isset($enableAdd)){?>
<?php echo $this->Form->create('User', array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-7',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal',
)); ?>
	<fieldset>
	<legend><?php echo __('Add User'); ?></legend>
	<?php echo $this->Form->input('username', array(
		'placeholder' => 'username'
	)); ?>

	<?php echo $this->Form->input('password', array(
		'placeholder' => 'Password'
	)); ?>

	<?php echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin', 'author' => 'Author','reader' => 'Reader')
        ));
    ?>
    	<?php 
	// echo $this->Form->input('group', array(
	// 	'placeholder' => 'group'
	// )); 
	echo $this->Form->input('group',array
	(
	    'type'=>'select',
	    'options'=>$groupName,
	    'multiple'=> 'checkbox',
		'value'=>0,
	    // 'style' => 'width: 200px',
	    // 'onchange' => 'submit(this.form)',
	    //'selected' => $selected,  // 規定値をvalueで指定
	    // 'div' => false           // div親要素の有無(true/false)
	    // 'size' => 1,          // 高さ設定(リストボックスとして表示)
	    //'empty' => false,          // 空白を許可
	    //'div'   => 'list-group nav nav-tabs nav-stacked fixed-sidebar',
	    'class' => 'col-xs-6 col-sm-4 col-md-6'
	 ));
	    //echo $this->element('selectGroup',$groupName);
	?>
	<div class="form-group">
		<?php echo $this->Form->submit('Sign up', array(
			'div' => 'col col-md-6 col-md-offset-2',
			'class' => 'btn btn-lg btn-primary',
			'style' => 'padding:8px 20px;'
		)); ?>
	</div>
	</fieldset>
<?php echo $this->Form->end(); ?>

</div>
</div>
</div>
<?php }?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
