<?php
/*echo '<pre>';
print_r($data1);
echo '</pre>';*/
?>
<?php $this->Html->script('amcharts/Chart.Core',  array('inline' => false));?>
<?php $this->Html->script('amcharts/Chart.Radar', array('inline' => false));?>

<script type="text/javascript">
    var dataset1 = JSON.parse('<?=json_encode($data1);?>');
    var dataset2 = JSON.parse('<?=json_encode($data2);?>');
    var label1 = '<?php echo $name1;?>';
    var label2 = '<?php echo $name2;?>';
</script>
<?php echo $this->Html->script('metrics', array('inline' => true));?>
<?php echo $this->element('pagepath', array("secondPath" => __("レイヤー"),"thirdPath" => __("メトリクスレーダーチャート")));?>

<div class="page-header">
	<h1><small><?php echo __('メトリクスレーダーチャート');?></small></h1>
    <?php echo $this->element('selectForm5', array("groupName" => $groupName)); ?>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <canvas id="canvas"></canvas>
    </div>
<?php echo __('表の列をクリックすることで表示項目切り替え');?>
    <div class="col-md-12 col-sm-12" >
		<?php echo $this->element('metricstable', array("name" => $name1,"data" => $data1,"metricsName"=>substr($selectMetricsStr,4)));?>
		<?php echo $this->element('metricstable', array("name" => $name2,"data" => $data2,"metricsName"=>substr($selectMetricsStr,4)));?>
    </div>
</div>
