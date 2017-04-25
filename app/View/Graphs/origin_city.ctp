
<?php

//デバッグ用表示
   // echo 'デバッグ用表示';
    //echo '<pre>';
//echo $this->element('sql_dump');
    //echo '</pre>';
?>
<div data-role='page'>
</div>

<?php echo $this->element('pagepath', array("secondPath" => __("由来"),"thirdPath" => __("メトリクス領域図")));?>
<div class="page-header">
    <h1><small><?php echo __('メトリクス領域図');?></small></h1>
    <?php echo $this->element('selectForm5', array("groupName" => $groupName)); ?>
</div>
<script>
    var originalSum1 = JSON.parse('<?=json_encode($data1);?>');
    var originalSum2 = JSON.parse('<?=json_encode($data2);?>');
	var layer = JSON.parse('<?=json_encode($layer);?>');
</script>

<div class="row">
    <div class="col-md-6 col-sm-6">
		<div id="canvas-wrapper"></div>
		<canvas id="canvas1"style="border:1px solid;width:100%;height:auto"></canvas>
    </div>
	<div class="col-md-6 col-sm-6 ">
		<?php echo $this->element('originCityTable', array("name" => $ModelName1,"data" => $data1,"metricsName"=>substr($selectMetricsStr,4), "oriStr"=>$organizations));?>
    </div>
	<div class="col-md-6 col-sm-6">
		<canvas id="canvas2"style="border:1px solid;width:100%;height:auto"></canvas>
    </div>
	<div class="col-md-6 col-sm-6">
		<?php echo $this->element('originCityTable', array("name" => $ModelName2,"data" => $data2,"metricsName"=>substr($selectMetricsStr,4), "oriStr"=>$organizations));?>
    </div>
</div>
<?php echo $this->Html->script('originCity', array('inline' => true));?>
