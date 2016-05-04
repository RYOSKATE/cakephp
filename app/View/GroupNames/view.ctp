<div class="groupNames view">
<h2><?php echo __('Group Name'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($groupName['GroupName']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($groupName['GroupName']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Group Name'), array('action' => 'edit', $groupName['GroupName']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Group Name'), array('action' => 'delete', $groupName['GroupName']['id']), array(), __('Are you sure you want to delete # %s?', $groupName['GroupName']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Group Names'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Group Name'), array('action' => 'add')); ?> </li>
	</ul>
</div>
