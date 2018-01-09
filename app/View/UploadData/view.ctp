<div class="uploadData view">
<h2><?php echo __('Upload Data'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($uploadData['UploadData']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($uploadData['UploadData']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modelname'); ?></dt>
		<dd>
			<?php echo $this->Html->link($uploadData['Modelname']['name'], array('controller' => 'modelnames', 'action' => 'view', $uploadData['Modelname']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo h($uploadData['User']['username']); ?>
			<?php //echo $this->Html->link($uploadData['User']['username'], array('controller' => 'users', 'action' => 'view', $uploadData['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($uploadData['UploadData']['comment']); ?>
			&nbsp;
		</dd>	
	</dl>
</div>
	
<div class="related">
	<h3><?php echo __('Part of Related Data'); ?></h3>
	<?php if (!empty($uploadData['Graph'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-hover table-condensed">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('filepath'); ?></th>
		<th><?php echo __('groups'); ?></th>
		<th><?php echo __('metrics'); ?></th>
		<!--<th class="actions"><?php //echo __('Actions'); ?></th>-->
	</tr>
	<?php 
	$i=0;
	foreach ($uploadData['Graph'] as $graph): 
	if(20<++$i)break;?>
		<tr>
			<td><?php echo $graph['id']; ?></td>
			<td><?php echo $graph['filepath']; ?></td>
			<td><?php echo $graph['groups']; ?></td>
			<td><?php echo $graph['metrics']; ?></td>
			<!--<td class="actions">
				<?php //echo $this->Html->link(__('View'), array('controller' => 'graphs', 'action' => 'view', $graph['id'])); ?>
				<?php //echo $this->Html->link(__('Edit'), array('controller' => 'graphs', 'action' => 'edit', $graph['id'])); ?>
				<?php //echo $this->Form->postLink(__('Delete'), array('controller' => 'graphs', 'action' => 'delete', $graph['id']), array(), __('Are you sure you want to delete # %s?', $graph['id'])); ?>
			</td>-->
		</tr>

	<?php endforeach; ?>
	</table>
<?php endif; ?>	
</div>
