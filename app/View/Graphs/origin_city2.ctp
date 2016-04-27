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
    <?php echo $this->element('selectForm4', array("modelName" => $modelName,"groupName" => $groupName)); ?>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6">
 		<div id="canvas-wrapper"></div>
 		<?php echo $this->Html->script('originCity2', array('inline' => true));?>
    </div>
</div>