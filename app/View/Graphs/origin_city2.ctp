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

<?php echo $this->element('pagepath', array("secondPath" => "モデル","thirdPath" => "由来比較(OriginCity)"));?>
<div class="page-header">
    <h1><small>由来比較(OriginCity)</small></h1>
    <?php //echo $this->element('selectForm3', array("modelName" => $modelName,"groupName" => $groupName)); ?>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
	
 	<div id="canvas-wrapper"></div>
 	<?php echo $this->Html->script('originCity2', array('inline' => true));?>

    </div>
	<div class="col-md-1 col-sm-1">
	</div>
	<div class="col-md-5 col-sm-5">

		<?php echo $this->element('originCityTable', array("name" => $leftModelName,"data" => $model1,"metricsName"=>$selectMetricsStr));?>
    </div>
	<div class="col-md-12 col-sm-12">
	</div>
	<div class="col-md-6 col-sm-6">
		<canvas id="canvas2" width="440" height="440" style="border:1px solid;"></canvas>
    </div>
	<div class="col-md-1 col-sm-1">
	</div>
	<div class="col-md-5 col-sm-5">
		<?php echo $this->element('originCityTable', array("name" => $rightModelName,"data" => $model2,"metricsName"=>$selectMetricsStr));?>
    </div>
</div>