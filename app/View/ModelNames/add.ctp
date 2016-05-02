<div class="modelNames form">
<?php echo $this->Form->create('ModelName'); ?>
	<fieldset>
		<legend><?php echo __('Add Model Name'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Model Names'), array('action' => 'index')); ?></li>
	</ul>
</div>
