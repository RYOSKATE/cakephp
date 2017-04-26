<div class="layerpaths form">
<?php echo $this->Form->create('Layerpath'); ?>
	<fieldset>
		<legend><?php echo __('Add Layerpath'); ?></legend>
	<?php
		echo $this->Form->input('layer_id');
		echo $this->Form->input('path');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

<fieldset>
  <legend><?php echo __('CSVファイルでの一括上書き');?></legend>
        <?php
        echo $this->Form->create('Layerpath', array(
            'inputDefaults' => array(
                'wrapInput' => false,
                'class' => 'form-control'
            ),
            'class' => 'well form-inline',
            'enctype' => 'multipart/form-data',
        ));
            echo $this->element('localCSV',array("formname" => 'selectCSV'));

            echo $this->Form->input(__('アップロード'), array
            (
                'label'=>"　",
                'name'=>'set',
                'type'=>'submit',
                'onchange' => 'submit(this.form)',
                'style'=>"width:100%;",
            ));
            echo $this->Form->end();
        ?>
 </div>
</fieldset>

<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Layerpaths'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Layers'), array('controller' => 'layers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Layer'), array('controller' => 'layers', 'action' => 'add')); ?> </li>
	</ul>
</div>
