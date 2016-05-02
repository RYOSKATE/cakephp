<div class="modelNames view">
<h2><?php echo __('Model Name'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($modelName['ModelName']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($modelName['ModelName']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Model Name'), array('action' => 'edit', $modelName['ModelName']['id'])); ?> </li>
		<!--<li><?php //echo $this->Form->postLink(__('Delete Model Name'), array('action' => 'delete', $modelName['ModelName']['id']), array(), __('Are you sure you want to delete # %s?', $modelName['ModelName']['id'])); ?> </li>-->
		<li><?php echo $this->Html->link(__('List Model Names'), array('action' => 'index')); ?> </li>
		<!--<li><?php //echo $this->Html->link(__('New Model Name'), array('action' => 'add')); ?> </li>-->
	</ul>
</div>
