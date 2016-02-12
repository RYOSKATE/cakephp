
<?php
//デバッグ用表示
    echo 'デバッグ用表示';
    echo '<pre>';
    print_r($model1);
    print_r($model2);
    echo '</pre>';
?>


<div data-role='page'>
</div>

<?php echo $this->element('pagepath', array("secondPath" => "モデル","thirdPath" => "由来比較(領域グラフ)"));?>
<div class="page-header">
    <h1><small>由来比較(領域グラフ)</small></h1>
    <?php echo $this->element('selectForm3', array("modelName" => $modelName,"groupName" => $groupName)); ?>
</div>
	<canvas id="canvas1" width="700" height="500" style="border:1px solid;"></canvas>
    <br>
	<canvas id="canvas2" width="700" height="500" style="border:1px solid;"></canvas>
<script>
    var originalSum1 = JSON.parse('<?=json_encode($model1);?>');
    var originalSum2 = JSON.parse('<?=json_encode($model2);?>');
</script>
<?php echo $this->Html->script('originCity', array('inline' => true));?>