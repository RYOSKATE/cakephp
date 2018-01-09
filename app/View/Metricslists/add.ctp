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
<h4><?php echo __('csvファイルフォーマット');?></h4>
<ul>
    <?php echo __('
        <li>対応フォーマット:CSV(utf8)</li>
        <li>ヘッダー行、インデックス列なし</li>
        <li>0列目:メトリクス名</li>
        <li>1列名,メトリクスの型(int,float,string)</li>
		<li>例:<br><code>
		loc,int<br>
		numOfDefects,int<br>
		filetype,string
		</code></li>
    ');?>
</ul>
<h4><?php echo __('アップロード時の注意');?></h4>
<ul>
    <?php echo __('
		<li>データ用CSVには0列名にファイルパス,n列目に開発グループを含みますが、これらはメトリクスではないため1列目からn-1列目が対象になります。</li>
    ');?>
</ul>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Metricslists'), array('action' => 'index')); ?></li>
	</ul>
</div>
