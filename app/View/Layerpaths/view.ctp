<div class="layerpaths view">
<h2><?php echo __('Layerpath'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($layerpath['Layerpath']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Layer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($layerpath['Layer']['name'], array('controller' => 'layers', 'action' => 'view', $layerpath['Layer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Path'); ?></dt>
		<dd>
			<?php echo h($layerpath['Layerpath']['path']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Layerpath'), array('action' => 'edit', $layerpath['Layerpath']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Layerpath'), array('action' => 'delete', $layerpath['Layerpath']['id']), array(), __('Are you sure you want to delete # %s?', $layerpath['Layerpath']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Layerpaths'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Layerpath'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Layers'), array('controller' => 'layers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Layer'), array('controller' => 'layers', 'action' => 'add')); ?> </li>
	</ul>
</div>
