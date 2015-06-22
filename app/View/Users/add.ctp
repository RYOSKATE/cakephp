<div class="container">  
<div class="row">
<div class="col-md-8 col-md-offset-2">

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
	<?php echo $this->Form->input('group', array(
		'placeholder' => 'group'
	)); ?>
	<?php echo $this->Form->input('password', array(
		'placeholder' => 'Password'
	)); ?>

	<?php echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin', 'author' => 'Author','reader' => 'Reader')
        ));
    ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Sign in', array(
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
