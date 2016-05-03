<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('username',array('disabled'=>'disabled'));
		echo $this->Form->input('password',array('disabled'=>'disabled'));
		echo $this->Form->input('role', array(
            'options' => array('admin' => 'Admin', 'author' => 'Author','reader' => 'Reader')
        ));
		?>

<div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none')?'block':'none';">
<a style="cursor:pointer;">グループ名▼</a>
</div>
<!--// 折り畳み展開ポインタ -->
 
<!-- 折り畳まれ部分 -->
<div id="open" style="display:none;clear:both;">
<?php
			echo $this->Form->input('group',array
	(
	    'type'=>'select',
	    'options'=>$groupName,
	    'multiple'=> 'checkbox',
	    'class' => 'col-xs-6 col-sm-4 col-md-3 col-lg-2 '
	 ));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php if($userData['id']!=$this->Form->value('User.id')){?>
		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
		<?php } ?>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
