<div class="layers view">
<h2><?php echo __('Layer'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($layer['Layer']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Layer'); ?></dt>
		<dd>
			<?php echo h($layer['Layer']['layer']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($layer['Layer']['name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Layer'), array('action' => 'edit', $layer['Layer']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Layer'), array('action' => 'delete', $layer['Layer']['id']), array(), __('Are you sure you want to delete # %s?', $layer['Layer']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Layers'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Layer'), array('action' => 'add')); ?> </li>
	</ul>
</div>
