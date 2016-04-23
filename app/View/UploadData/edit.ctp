<div class="uploadData form">
<?php echo $this->Form->create('UploadData'); ?>
	<fieldset>
		<legend><?php echo __('Edit Upload Data'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('date');
		echo $this->Form->input('modelname_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('comment');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('UploadData.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('UploadData.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Upload Data'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Modelnames'), array('controller' => 'modelnames', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Modelname'), array('controller' => 'modelnames', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Graphs'), array('controller' => 'graphs', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Graph'), array('controller' => 'graphs', 'action' => 'add')); ?> </li>
	</ul>
</div>
