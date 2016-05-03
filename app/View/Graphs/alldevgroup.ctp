
<?php $this->Html->script('amcharts/xy', array('inline' => false));?>

<?php echo $this->element('pagepath', array("secondPath" => "全開発グループ","thirdPath" => "欠陥数散布図"));?>

<div class="page-header">
    <h1><small>欠陥数散布図</small></h1>
     <?php echo $this->element('selectForm4'); ?>
</div>
<h4>モデル名:<?php echo $name;?></h4>
<h6>メトリクス:<?php echo substr($selectMetricsStr,4);?></h6>
<div id="chartdiv" style="height:500px;"></div>

<!--<div class="col-md-3 col-sm-3 pull-right">
    <?php 
        echo $this->Form->input('順位表示数',array
        (
            'id'=>'dispNum',
            'type'=>'number',
            'class' => 'form-control',
            'onchange' => 'set(this.value)',
            'step'=>1,
            'min'=>0,
            'max'=>count($data),
            'value'=>10,
         ));
    ?>
</div>-->

<div class="row">
    <div class="col-md-12 col-sm-12" >
    <table class="table table-hover table-condensed" id ="table">
        <thead>
        <tr>
            <th>順位</th>
            <th>メトリクス合計値</th>
            <th>ファイルあたりのメトリクス値</th>
            <th>メトリクス密度(/kLOC)</th>
        </tr>
        </thead>
        <tbody id = "rankTable"></tbody>
    </table>
    </div>
</div>

<!-- グラフ・表の作成処理 -->
<script type="text/javascript">  
    var getData = JSON.parse('<?=json_encode($data);?>');
    var metricsName = JSON.parse('<?=json_encode(substr($selectMetricsStr,4));?>');
</script>
<?php echo $this->Html->script('alldevgroup', array('inline' => true));?>