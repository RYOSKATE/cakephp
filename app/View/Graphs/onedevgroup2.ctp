<?php
    //デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // print_r($tree);
    // echo '</pre>';
?>

<?php $this->Html->script('amcharts/Chart.Core', array('inline' => false));?>
<?php $this->Html->script('amcharts/Chart.Radar', array('inline' => false));?>
<?php $this->Html->script('d3.v2', array('inline' => false));?>
<?php $this->Html->css('filemetrics', array('inline' => false));?>
<?php echo $this->element('pagepath', array("secondPath" => __("各開発グループ"),"thirdPath" => __("メトリクスファイルマップ")));?>

<div class="page-header">
	<h1><small><?php echo __('メトリクスファイルマップ');?></small></h1>
  <?php echo $this->element('selectForm3'); ?>
  
<h4><?php echo __('モデル名');?>:<?php echo $selectModelName;?></h4>
<h6><?php echo __('メトリクス');?>:<?php echo substr($selectMetricsStr,4);?></h6>


  <?php
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                          array('div' => 'form-group',),
                                          'class' => 'well form-inline',
                                          )
                              );
    echo $this->Form->input('表示ディレクトリ階層',array
    (
    	  'id'=>'layer',
        'type'=>'number',
        'class' => 'form-control',
        'step'=>1,
        'min'=>0,
        'max'=>$depth,
        'value'=>1,
        // 'list'=>array(1,2,3),
     ));	
  ?>
  <label for="select"><?php echo __('ブロック面積');?></label>
  <select id = "select" class = "form-control">
	  <option value="size"><?php echo substr($selectMetricsStr,4);?></option>
    <option value="count"><?php echo __('ファイル数');?></option>
  </select>
  <input id = "zoomreset" class = 'form-control' type="button" value="<?php echo __('全体を表示');?>">
  <?php echo $this->Form->end();?>

</div>
<div id="body" style="border:1px solid;width:100%;height:auto"></div>
<p id="path"><?php echo __('表示パス');?>:root/</p>
<div id="footer">
  <div>
    <?php echo __('
    ○操作方法<br>
  ・レイヤースピンボックスでファイル階層を切り替え<br>
  ・size:欠陥の数  count:ディレクトリ以下のファイル数<br>
  ・ディレクトリブロックをクリックでズーム(alt:低速ズーム)<br>
  (sizeが0で重なりあった複数のブロックを同時にクリックするとレイアウトが崩れる不具合あり)
  ');
?>  
  </div>
</div>

      <!-- <canvas id="canvas" height="200" width="450"></canvas> -->
<br>      
<canvas id="canvas"></canvas>

<!-- グラフ・表の作成処理 -->
<script type="text/javascript"> 
  var originPathJson = JSON.parse('<?php echo $tree; ?>');
  var chartMetricsStr = JSON.parse('<?php echo json_encode($chartMetricsStr); ?>');
</script>
<?php echo $this->Html->script('filemetrics', array('inline' => true));?>