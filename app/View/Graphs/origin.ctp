
<?php
//デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // print_r($model1);
    // print_r($model2);
    // echo '</pre>';
?>
<?php $this->Html->script('amcharts/pie', array('inline' => false));?>

<script>
    var defactsByOrigin1 = JSON.parse('<?=json_encode($model1);?>');
    var defactsByOrigin2 = JSON.parse('<?=json_encode($model2);?>');
</script>
<div data-role='page'>
<?php echo $this->Html->script('origin', array('inline' => true));?>
</div>
<?php echo $this->element('pagepath', array("secondPath" => __("由来"),"thirdPath" => __("欠陥数円グラフ")));?>
<div class="page-header">
    <h1><small><?php echo __('欠陥数円グラフ');?></small></h1>
    <?php echo $this->element('selectForm4'); ?>
</div>
<!-- Nav tabs -->
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