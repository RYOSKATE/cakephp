<?php $this->Html->script('amcharts/serial', array('inline' => false));?>
<?php $this->Html->script('amcharts/amstock', array('inline' => false));?>
<?php

    // echo '全てのstickies';
    // echo '<pre>';
    // print_r($stickies);
    // echo '</pre>';
?>
<script type="text/javascript">
	var data = new Array();
	data.push(JSON.parse('<?=json_encode($data1);?>'));
	data.push(JSON.parse('<?=json_encode($data2);?>'));
	data.push(JSON.parse('<?=json_encode($data3);?>'));
	data.push(JSON.parse('<?=json_encode($data4);?>'));
	var modelName = JSON.parse('<?=json_encode($model);?>');
</script>
<?php echo $this->Html->script('onedevgroup', array('inline' => true));?>

<?php echo $this->element('pagepath', array("secondPath" => "各開発グループ","thirdPath" => "メトリクス遷移"));?>

<div class="page-header">
    <h1><small>メトリクス遷移</small></h1>
    <?php echo $this->element('selectForm2'); ?>
</div>

<div id="chartdiv" style="height:600px;"></div>