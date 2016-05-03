
<?php
//デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // print_r($model1);
    // print_r($model2);
    // echo '</pre>';
?>


<div data-role='page'>
</div>

<?php echo $this->element('pagepath', array("secondPath" => "モデル","thirdPath" => "由来比較(領域図)"));?>
<div class="page-header">
    <h1><small>由来比較(領域図)</small></h1>
    <?php echo $this->element('selectForm5', array("groupName" => $groupName)); ?>
</div>
<script>
    var originalSum1 = JSON.parse('<?=json_encode($model1);?>');
    var originalSum2 = JSON.parse('<?=json_encode($model2);?>');
</script>

<div class="row">
    <div class="col-md-6 col-sm-6">
		<div id="canvas-wrapper"></div>
		<canvas id="canvas1"style="border:1px solid;width:100%;height:auto"></canvas>
    </div>
	<div class="col-md-6 col-sm-6 ">
		<?php echo $this->element('originCityTable', array("name" => $ModelName1,"data" => $model1,"metricsName"=>$selectMetricsStr));?>
    </div>
	<div class="col-md-6 col-sm-6">
		<canvas id="canvas2"style="border:1px solid;width:100%;height:auto"></canvas>
    </div>
	<div class="col-md-6 col-sm-6">
		<?php echo $this->element('originCityTable', array("name" => $ModelName2,"data" => $model2,"metricsName"=>$selectMetricsStr));?>
    </div>
</div>
<?php echo $this->Html->script('originCity', array('inline' => true));?>