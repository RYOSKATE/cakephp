<div class="groupNames form">
<?php echo $this->Form->create('GroupName'); ?>
	<fieldset>
		<legend><?php echo __('Add Group Name'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Group Names'), array('action' => 'index')); ?></li>
	</ul>
</div>
