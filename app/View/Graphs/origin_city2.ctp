<?php
//デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
?>


<div data-role='page'>
</div>

<?php echo $this->element('pagepath', array("secondPath" => "モデル","thirdPath" => "由来比較(OriginCity)"));?>
<div class="page-header">
    <h1><small>由来比較(OriginCity)</small></h1>
    <?php echo $this->element('selectForm4'); ?>
</div>
<div class="row">
    <div class="col-md-12 col-sm-12">
         <div id="canvas-wrapper"></div>
    </div>
    <div class="col-md-12 col-sm-12">
		<?php echo $this->element('originCityTable2', array("name" => $selectModelName,"data" => $data,"metricsName"=>$selectMetricsName));?>
    </div>
</div>

<script>
    var data = JSON.parse('<?=json_encode($data);?>');
</script>
<?php echo $this->Html->script('originCity2', array('inline' => true));?>
