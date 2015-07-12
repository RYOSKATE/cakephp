
<?php $this->Html->script('amcharts/xy', array('inline' => false));?>

<?php 
    echo $this->element('pagepath', array(
                                "secondPath" => "全開発グループ",
                                "thirdPath" => "欠陥数散布図"));
?>

<div class="page-header">
    <?php echo $this->element('selectForm1'); ?>
</div>

<?php echo $time;?>

<div id="chartdiv" style="height:500px;"></div>

<div class="col-md-3 col-sm-3 pull-right">
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
</div>

<div class="row">
    <div class="col-md-12 col-sm-12" >
    <table class="table table-hover table-condensed" id ="table">
        <thead>
        <tr>
            <th>順位</th>
            <th>合計欠陥数</th>
            <th>ファイルあたりの欠陥数</th>
            <th>欠陥密度(LOC)</th>
        </tr>
        </thead>
        <tbody id = "rankTable"></tbody>
    </table>
    </div>
</div>

<!-- グラフ・表の作成処理 -->
<script type="text/javascript">  var getData = JSON.parse('<?=json_encode($data);?>');</script>
<?php echo $this->Html->script('alldevgroup', array('inline' => true));?>