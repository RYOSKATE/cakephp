<div class="metricslists view">
<h2><?php echo __('Metricslist'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($metricslist['Metricslist']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($metricslist['Metricslist']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($metricslist['Metricslist']['type']); ?>
			&nbsp;
		</dd>	
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Metricslist'), array('action' => 'edit', $metricslist['Metricslist']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Metricslist'), array('action' => 'delete', $metricslist['Metricslist']['id']), array(), __('Are you sure you want to delete # %s?', $metricslist['Metricslist']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Metricslists'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Metricslist'), array('action' => 'add')); ?> </li>
	</ul>
</div>
