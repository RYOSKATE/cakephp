<div class="metricslists form">
<?php echo $this->Form->create('Metricslist'); ?>
	<fieldset>
		<legend><?php echo __('Edit Metricslist'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Metricslist.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Metricslist.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Metricslists'), array('action' => 'index')); ?></li>
	</ul>
</div>
