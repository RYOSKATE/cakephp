<div class="groupNames form">
<?php echo $this->Form->create('GroupName'); ?>
	<fieldset>
		<legend><?php echo __('Edit Group Name'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('Update', array
    (
    	'label'=>"　",
    	'name'=>'update',
    	'type'=>'submit',
    ));
	echo '<br>';
		echo $this->Form->input('Merge', array
    (
    	'label'=>"すでに存在するグループと統合する場合はMergeを実行してください。",
    	'name'=>'merge',
    	'type'=>'submit',
    ));
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('GroupName.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('GroupName.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Group Names'), array('action' => 'index')); ?></li>
	</ul>
</div>
