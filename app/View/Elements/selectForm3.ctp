<?php 
    echo $this->element('formCreate');
    echo '<div class="row">';
        echo '<div class="col-sm-6 col-md-6 col-lg-6">';
        echo $this->element('seceletCSVid', array("formname" => 'CSV_ID',"isAllowEmpty" => false));
        echo '</div>';
        echo '<div class="col-sm-6 col-md-6 col-lg-6">';
        echo $this->element('localCSV',array("formname" => __('selectCSV')));
        echo '</div>';
        echo '<div class="col-sm-6 col-md-6 col-lg-6">';
        echo $this->element('selectGroup',$groupName); 
        echo '</div>';
        echo '<div class="col-sm-6 col-md-6 col-lg-6">';
        echo $this->element('selectMetrics',array("selectMetrics" => $selectMetrics,"metricsList" => $metricsList)); 
        echo '</div>';
        echo '<div class="col-sm-6 col-md-6 col-lg-6">';
        echo $this->element('setButton'); 
        echo '</div>';
        ?>
<div onclick="obj=document.getElementById('open').style; obj.display=(obj.display=='none')?'block':'none';">
<a style="cursor:pointer;"><?php 
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo __('メトリクス(チャート表示)▼');
    echo '</div>';
?></a>
</div>
<!--// 折り畳み展開ポインタ -->
<!-- 折り畳まれ部分 -->
<div id="open" style="display:none;clear:both;">
<?php
    
    echo '<br><div class="col-sm-12 col-md-12 col-lg-12">';
    echo __('選択したメトリクスをレーダーチャート表示します。');
    echo '</div>';

    for($i=0;$i<count($metricsList);++$i)
    {
        echo '<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">';
        echo $this->Form->input('Metrics'.$i,array
        (
            'type'=>'select',
            'label'=>__('メトリクス'.$i),
            'options'=>$metricsList,
            //'value'=>$i,//デフォルトは欠陥数
            // 'style' => 'width: 200px',
            // 'onchange' => 'submit(this.form)',
            //'selected' => $selectMetrics,  // 規定値をvalueで指定
            // 'div' => false           // div親要素の有無(true/false)
            // 'size' => 1,          // 高さ設定(リストボックスとして表示)
            //'empty' => false,          // 空白を許可
            //'div'   => 'list-group nav nav-tabs nav-stacked fixed-sidebar',
            'class' => 'form-control',
            'empty' => true,
            'style'=>"width:100%;",
            'disabled' => array(2,7)
        ));        
        echo '</div>';
    } 
?>
</div>       
        <?php
        echo '</div>';
    echo '</div>';
    
    echo $this->Form->end();
?>