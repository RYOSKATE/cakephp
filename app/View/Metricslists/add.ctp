<div class="metricslists form">
<?php echo $this->Form->create('Metricslist'); ?>
	<fieldset>
		<legend><?php echo __('Add Metricslist'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Metricslists'), array('action' => 'index')); ?></li>
	</ul>
</div>
