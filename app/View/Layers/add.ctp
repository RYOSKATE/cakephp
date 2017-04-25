<div class="layers form">
<?php echo $this->Form->create('Layer'); ?>
	<fieldset>
		<legend><?php echo __('Add Layer'); ?></legend>
	<?php
		echo $this->Form->input('layer');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Layers'), array('action' => 'index')); ?></li>
	</ul>
</div>
