<?php
/*echo '<pre>';
print_r($data1);
echo '</pre>';*/
?>
<?php $this->Html->script('amcharts/Chart.Core',  array('inline' => false));?>
<?php $this->Html->script('amcharts/Chart.Radar', array('inline' => false));?>

<?php echo $this->element('pagepath', array("secondPath" => "モデル","thirdPath" => "メトリクス比較"));?>

<div class="page-header">
	<h1><small>メトリクス比較</small></h1>
    <?php echo $this->element('selectForm2', array("modelName" => $modelName,"groupName" => $groupName)); ?>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <canvas id="canvas"></canvas>
    </div>
    <div class="col-md-12 col-sm-12" >
		<?php echo $this->element('metricstable', array("name" => $name1,"data" => $data1));?>
		<?php echo $this->element('metricstable', array("name" => $name2,"data" => $data2));?>
    </div>
</div>

<script type="text/javascript">
	var dataset1 = JSON.parse('<?=json_encode($data1);?>');
	var dataset2 = JSON.parse('<?=json_encode($data2);?>');
	var label1 = '<?php echo $name1;?>';
	var label2 = '<?php echo $name2;?>';
</script>

<?php echo $this->Html->script('metrics', array('inline' => true));?>