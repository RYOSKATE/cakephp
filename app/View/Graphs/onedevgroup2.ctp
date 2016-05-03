<?php
    //デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // //print_r($tree);
    // echo '</pre>';
?>

<?php $this->Html->script('amcharts/Chart.Core', array('inline' => false));?>
<?php $this->Html->script('amcharts/Chart.Radar', array('inline' => false));?>
<?php $this->Html->script('d3.v2', array('inline' => false));?>
<?php $this->Html->css('filemetrics', array('inline' => false));?>
<?php echo $this->element('pagepath', array("secondPath" => "各開発グループ","thirdPath" => "ファイルメトリクス"));?>

<div class="page-header">
	<h1><small>ファイルメトリクス</small></h1>
  <?php echo $this->element('selectForm3'); ?>


  <?php
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                          array('div' => 'form-group',),
                                          'class' => 'well form-inline',
                                          )
                              );
    echo $this->Form->input('レイヤー',array
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
  <select id = "select" class = "form-control">
	  <option value="size">Size</option>
    <option value="count">Count</option>
  </select>
  <input id = "zoomreset" class = 'form-control' type="button" value="全体を表示">
  <?php echo $this->Form->end();?>

</div>
<div id="body"></div>
<p id="path">表示パス:root/</p>
<div id="footer">
  <div>
  ○操作方法<br>
  ・レイヤースピンボックスでファイル階層を切り替え<br>
  ・size:欠陥の数  count:ディレクトリ以下のファイル数<br>
  ・ディレクトリブロックをクリックでズーム(alt:低速ズーム)<br>
  (sizeが0で重なりあった複数のブロックを同時にクリックするとレイアウトが崩れる不具合あり)
  </div>
</div>

      <!-- <canvas id="canvas" height="200" width="450"></canvas> -->
<canvas id="canvas"></canvas>

<!-- グラフ・表の作成処理 -->
<script type="text/javascript"> var originPathJson = JSON.parse('<?php echo $tree; ?>');</script>
<?php echo $this->Html->script('filemetrics', array('inline' => true));?>