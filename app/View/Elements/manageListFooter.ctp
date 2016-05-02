<div class="actions">
	<h4><?php echo __('Relation'); ?></h4>
	<ul>
		<li><?php echo $this->Html->link(__('UploadDatas'), array('controller' => 'upload_data','action' => 'index')); ?> </li>			
		<li><?php echo $this->Html->link(__('ModelNames'), array('controller' => 'model_names','action' => 'index')); ?> </li>		
		<li><?php echo $this->Html->link(__('Users'), array('controller' => 'users','action' => 'index')); ?> </li>
	</ul>
</div>