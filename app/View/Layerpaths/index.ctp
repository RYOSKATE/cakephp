<div class="layerpaths index">
	<h2><?php echo __('Layerpaths'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-hover table-condensed">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('layer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('path'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($layerpaths as $layerpath): ?>
	<tr>
		<td><?php echo h($layerpath['Layerpath']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($layerpath['Layer']['name'], array('controller' => 'layers', 'action' => 'view', $layerpath['Layer']['id'])); ?>
		</td>
		<td><?php echo h($layerpath['Layerpath']['path']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $layerpath['Layerpath']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $layerpath['Layerpath']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $layerpath['Layerpath']['id']), array(), __('Are you sure you want to delete # %s?', $layerpath['Layerpath']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Layerpath'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Layers'), array('controller' => 'layers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Layer'), array('controller' => 'layers', 'action' => 'add')); ?> </li>
	</ul>
</div>
