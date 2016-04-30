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
			<?php echo $this->Html->link($uploadData['User']['username'], array('controller' => 'users', 'action' => 'view', $uploadData['User']['id'])); ?>
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
	<h3><?php echo __('Related Graphs'); ?></h3>
	<?php if (!empty($uploadData['Graph'])): ?>
	<table cellpadding = "0" cellspacing = "0" class="table table-hover table-condensed">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('filepath'); ?></th>
		<th><?php echo __('1'); ?></th>
		<th><?php echo __('2'); ?></th>
		<th><?php echo __('3'); ?></th>
		<th><?php echo __('4'); ?></th>
		<th><?php echo __('5'); ?></th>
		<th><?php echo __('6'); ?></th>
		<th><?php echo __('7'); ?></th>
		<th><?php echo __('8'); ?></th>
		<th><?php echo __('9'); ?></th>
		<th><?php echo __('10'); ?></th>
		<th><?php echo __('11'); ?></th>
		<th><?php echo __('12'); ?></th>
		<th><?php echo __('13'); ?></th>
		<th><?php echo __('14'); ?></th>
		<th><?php echo __('15'); ?></th>
		<th><?php echo __('16'); ?></th>
		<th><?php echo __('17'); ?></th>
		<th><?php echo __('18'); ?></th>
		<th><?php echo __('19'); ?></th>
		<th><?php echo __('20'); ?></th>
		<th><?php echo __('21'); ?></th>
		<th><?php echo __('22'); ?></th>
		<th><?php echo __('23'); ?></th>
		<th><?php echo __('24'); ?></th>
		<th><?php echo __('25'); ?></th>
		<!--<th class="actions"><?php //echo __('Actions'); ?></th>-->
	</tr>
	<?php foreach ($uploadData['Graph'] as $graph): ?>
		<tr>
			<td><?php echo $graph['id']; ?></td>
			<td><?php echo $graph['filepath']; ?></td>
			<td><?php echo $graph['1']; ?></td>
			<td><?php echo $graph['2']; ?></td>
			<td><?php echo $graph['3']; ?></td>
			<td><?php echo $graph['4']; ?></td>
			<td><?php echo $graph['5']; ?></td>
			<td><?php echo $graph['6']; ?></td>
			<td><?php echo $graph['7']; ?></td>
			<td><?php echo $graph['8']; ?></td>
			<td><?php echo $graph['9']; ?></td>
			<td><?php echo $graph['10']; ?></td>
			<td><?php echo $graph['11']; ?></td>
			<td><?php echo $graph['12']; ?></td>
			<td><?php echo $graph['13']; ?></td>
			<td><?php echo $graph['14']; ?></td>
			<td><?php echo $graph['15']; ?></td>
			<td><?php echo $graph['16']; ?></td>
			<td><?php echo $graph['17']; ?></td>
			<td><?php echo $graph['18']; ?></td>
			<td><?php echo $graph['19']; ?></td>
			<td><?php echo $graph['20']; ?></td>
			<td><?php echo $graph['21']; ?></td>
			<td><?php echo $graph['22']; ?></td>
			<td><?php echo $graph['23']; ?></td>
			<td><?php echo $graph['24']; ?></td>
			<td><?php echo $graph['25']; ?></td>
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
