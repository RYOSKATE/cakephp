<?php
//デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
?>


<div data-role='page'>
</div>

<?php echo $this->element('pagepath', array("secondPath" => __("由来"),"thirdPath" => __("OriginCity")));?>
<div class="page-header">
    <h1><small><?php echo __('OriginCity');?></small></h1>
    <?php echo $this->element('selectForm6'); ?>
</div>
<h4><?php echo __('モデル名');?>:<div id="modelname"><?php echo $selectModelName;?></div></h4>
<h6><?php echo __('メトリクス');?>:<?php echo substr($selectMetricsStr,4);?></h6>
<div class="row">
    <div class="col-md-12 col-sm-12">
        <?php
        echo $this->Form->create('Graph',array('inputDefaults' =>
                                            array('div' => 'form-group',),
                                            'class' => 'well',
                                            )
                                );
        ?>
        <div class="row">
            <div class="col-md-2 col-sm-2">
                <button id="play" class="btn btn-default"><i class="glyphicon glyphicon-play"></i></button>
            </div>
            <div class="col-md-10 col-sm-10">
            <?php
            echo $this->Form->input('時系列',array
            (
                'id'=>'timeSlider',
                'type'=>'range',
                //'class' => 'form-control',
                'step'=>1,
                'min'=>0,
                'max'=>count($data)-1,
                'value'=>0,
                // 'list'=>array(1,2,3),
            ));
            ?>
            </div>
        </div>
  </div>
  <?php echo $this->Form->end();?>
    <div class="col-md-12 col-sm-12">
         <div id="canvas-wrapper"></div>
    </div>
    <div class="col-md-12 col-sm-12">
		<?php echo $this->element('originCityTable2', array("layer"=>$layer,"data" => $data[$uploadIdList[0]]));?>
    </div>
</div>

<script>

    var uploadList = JSON.parse('<?=json_encode($uploadList);?>');
    var uploadIdList = JSON.parse('<?=json_encode($uploadIdList);?>');
    var uploadDateList = JSON.parse('<?=json_encode($uploadDateList);?>');
    var data = JSON.parse('<?=json_encode($data);?>');
</script>
<?php echo $this->Html->script('originCity2', array('inline' => true));?>
