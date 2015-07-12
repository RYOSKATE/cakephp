
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

<?php echo $this->Html->script('origin', array('inline' => true));?>
<?php echo $this->element('pagepath', array("secondPath" => "モデル","thirdPath" => "由来比較"));?>

<div class="page-header">
    <h1><small>由来比較</small></h1>
    <?php echo $this->element('selectForm2', array("modelName" => $modelName,"groupName" => $groupName)); ?>
    <?php echo $this->element('localCSV'); ?>
</div>
<!-- Nav tabs -->
<!-- // 由来(1-7 = o2,o12,o1,o13,o123,o23,o3)0は使ってないらしい -->
<ul class="nav nav-tabs nav-justified" id = "mytab" role="tablist">
    <li id ="firstTab"><a href ="#o13" role="tab" data-toggle="tab">o13</a></li>
    <li><a href ="#o123"role="tab" data-toggle="tab">o123</a></li>        
    <li><a href ="#o23" role="tab" data-toggle="tab">o23</a></li>         
    <li><a href ="#o3"  role="tab" data-toggle="tab">o3</a></li>         
</ul>
<!-- Tab panes -->
<div class="tab-content">
    <?php 
        $originTag = array(4=>'o13',5=>'o123',6=>'o23',7=>'o3');
        for($i=4;$i<=7;++$i)
        {
            echo '<div class="tab-pane fade in active" id="'.$originTag[$i].'">';
            echo $this->element('piechart', array("leftModelName" => $leftModelName,"rightModelName" => $rightModelName,"No"=>$i));
            echo '</div>';
        }
    ?>
</div>