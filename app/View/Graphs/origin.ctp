
<?php
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // print_r($model1);
    // print_r($model2);
    // echo '</pre>';
?>
<?php $this->Html->script('amcharts/pie', array('inline' => false));?>

<script>
    var defactsByOrigin1 = JSON.parse('<?=json_encode($data1);?>');
    var defactsByOrigin2 = JSON.parse('<?=json_encode($data2);?>');
</script>
<div data-role='page'>
<?php echo $this->Html->script('origin', array('inline' => true));?>
</div>
<?php echo $this->element('pagepath', array("secondPath" => __("由来"),"thirdPath" => __("メトリクス円グラフ")));?>
<div class="page-header">
    <h1><small><?php echo __('メトリクス円グラフ');?></small></h1>
    <?php echo $this->element('selectForm5'); ?>
</div>
<!-- Nav tabs -->
<h4><?php echo __('メトリクス');?>:<?php echo substr($selectMetricsStr,4);?></h4>

<!-- // 由来(1-7 = o2,o12,o1,o13,o123,o23,o3)0は使ってないらしい -->
<ul class="nav nav-tabs nav-justified" id = "mytab" role="tablist">
    <li class = 'active'><a href ="#o13" role="tab" data-toggle="tab">o13</a></li>
    <li><a href ="#o123"role="tab" data-toggle="tab">o123</a></li>        
    <li><a href ="#o23" role="tab" data-toggle="tab">o23</a></li>         
    <li><a href ="#o3"  role="tab" data-toggle="tab">o3</a></li>         
</ul>
<!-- Tab panes -->
<div id="my-tab-content" class="tab-content">
    <?php 
        $originTag = array(4=>'o13',5=>'o123',6=>'o23',7=>'o3');
        echo '<div class="tab-pane fade in active" id="'.$originTag[4].'">';
        echo $this->element('piechart', array("leftModelName" => $ModelName1,"rightModelName" => $ModelName2,"No"=>4));
        echo '</div>';
        for($i=5;$i<=7;++$i)
        {
            echo '<div class="tab-pane fade" id="'.$originTag[$i].'">';
            echo $this->element('piechart', array("leftModelName" => $ModelName1,"rightModelName" => $ModelName2,"No"=>$i));
            echo '</div>';
        }
    ?>
</div>
<?php echo __('注意');?><br>
<?php echo __('メトリクス値nのファイルの個数が円グラフの要素になります。');?><br>
<?php echo __('ex:メトリクスに"欠陥の数"を選択時、円グラフに値0 1000(90%)という要素があれば欠陥数0のファイルが1000個あり、それは全ファイルの90%ということを表します。');?><br>
<?php echo __('"物理行数"など値の範囲が広く大きいメトリクスは処理が停止する可能性があります。');?><br>
<?php echo __('値が存在しない場合、グラフは表示されません。');?><br>