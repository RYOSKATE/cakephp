<div class="metricslists form">
<?php echo $this->Form->create('Metricslist'); ?>
	<fieldset>
		<legend><?php echo __('Add Metricslist'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('type');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>

<fieldset>
  <legend><?php echo __('CSVファイルでの一括上書き');?></legend>
        <?php
		echo $this->Form->create('MetricsList', array(
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

		<li><?php echo $this->Html->link(__('List Metricslists'), array('action' => 'index')); ?></li>
	</ul>
</div>
