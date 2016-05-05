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
<?php echo $this->element('pagepath', array("secondPath" => __("レイヤー"),"thirdPath" => __("欠陥数レーダーチャート")));?>

<div class="page-header">
	<h1><small><?php echo __('欠陥数レーダーチャート');?></small></h1>
    <?php echo $this->element('selectForm4', array("groupName" => $groupName)); ?>
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
