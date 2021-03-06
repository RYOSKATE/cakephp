<div class="groupNames index">
	<h2><?php echo __('Group Names'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-hover table-condensed">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
<?php if($userData['role']!='reader'){?>
			<th class="actions"><?php echo __('Actions'); ?></th>
<?php }?>			
	</tr>
	</thead>
	<tbody>
	<?php foreach ($groupNames as $groupName): ?>
	<tr>
		<td><?php echo h($groupName['GroupName']['id']); ?>&nbsp;</td>
		<td><?php echo h($groupName['GroupName']['name']); ?>&nbsp;</td>
		<td class="actions">
<?php if($userData['role']!='reader'){?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $groupName['GroupName']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $groupName['GroupName']['id']), array(), __('Are you sure you want to delete # %s?', $groupName['GroupName']['id'])); ?>
<?php }?>			
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
		echo $this->Paginator->prev('< ' . __('previous '), array('tag' => false), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ' ','tag' => false));
		echo $this->Paginator->next(__(' next') . ' >', array('tag' => false), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Group Name'), array('action' => 'add')); ?></li>
	</ul>
</div>
<?php echo $this->element('manageListFooter'); ?>