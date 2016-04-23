<div class="uploadData index">
	<h2><?php echo __('Upload Data'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('date'); ?></th>
			<th><?php echo $this->Paginator->sort('modelname_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('comment'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($uploadData as $uploadData): ?>
	<tr>
		<td><?php echo h($uploadData['UploadData']['id']); ?>&nbsp;</td>
		<td><?php echo h($uploadData['UploadData']['date']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($uploadData['Modelname']['name'], array('controller' => 'modelnames', 'action' => 'view', $uploadData['Modelname']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($uploadData['User']['id'], array('controller' => 'users', 'action' => 'view', $uploadData['User']['id'])); ?>
		</td>
		<td><?php echo h($uploadData['UploadData']['comment']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $uploadData['UploadData']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $uploadData['UploadData']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $uploadData['UploadData']['id']), array(), __('Are you sure you want to delete # %s?', $uploadData['UploadData']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Upload Data'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Modelnames'), array('controller' => 'modelnames', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Modelname'), array('controller' => 'modelnames', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Graphs'), array('controller' => 'graphs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Graph'), array('controller' => 'graphs', 'action' => 'add')); ?> </li>
	</ul>
</div>