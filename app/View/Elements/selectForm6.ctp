<?php 
    echo $this->element('formCreate');
    echo '<div class="row">';
    echo '<div class="col-sm-6 col-md-6 col-lg-6">';
    echo $this->Form->input('selectModel',array
	(
	    'type'=>'select',
	    'options'=>$modelName,
		'label'=> __('モデル選択'),
		// 'style' => 'width: 200px',
	    // 'onchange' => 'submit(this.form)',
	    //'selected' => $selectMetrics,  // 規定値をvalueで指定
	    // 'div' => false           // div親要素の有無(true/false)
	    // 'size' => 1,          // 高さ設定(リストボックスとして表示)
	    'empty' => false,          // 空白を許可
	    //'div'   => 'list-group nav nav-tabs nav-stacked fixed-sidebar',
		'style'=>"width:100%;",
	    'class' => 'form-control',
	 ));
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
    echo '</div>';
    echo $this->Form->end();
?>