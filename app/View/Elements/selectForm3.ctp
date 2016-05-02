<?php 
    echo $this->Form->create('Graph', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'label' => false,//array('class' => 'control-label'),
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => 'well form-inline',
    'enctype' => 'multipart/form-data',
    )); 

 echo $this->Form->input('CSV_ID2',array
	(
	    'type'=>'select',
	    'options'=>$uploadList,
		// 'style' => 'width: 200px',
	    // 'onchange' => 'submit(this.form)',
	    //'selected' => $selectMetrics,  // 規定値をvalueで指定
	    // 'div' => false           // div親要素の有無(true/false)
	    // 'size' => 1,          // 高さ設定(リストボックスとして表示)
	    //'empty' => false,          // 空白を許可
	    //'div'   => 'list-group nav nav-tabs nav-stacked fixed-sidebar',
	    'class' => 'form-control',
		'empty' => true,
	 ));
    echo $this->Form->input('CSV_ID2',array
	(
	    'type'=>'select',
	    'options'=>$uploadList,
		// 'style' => 'width: 200px',
	    // 'onchange' => 'submit(this.form)',
	    //'selected' => $selectMetrics,  // 規定値をvalueで指定
	    // 'div' => false           // div親要素の有無(true/false)
	    // 'size' => 1,          // 高さ設定(リストボックスとして表示)
	    //'empty' => false,          // 空白を許可
	    //'div'   => 'list-group nav nav-tabs nav-stacked fixed-sidebar',
	    'class' => 'form-control',
		'empty' => true,
	 ));
    echo $this->element('selectGroup',$groupName);
	echo $this->element('setButton');
	echo $this->element('selectMetrics',array($metricsList,$selectMetrics));
    if(isset($useLocalCSV))
    {
    ?><br><?php
    echo $this->Form->input('モデル名1(ローカルファイル)', array('placeholder' => 'Local Model1 Name'));
    echo $this->Form->file('選択ファイル1');//ファイル選択
    echo $this->Form->input('モデル名2(ローカルファイル)', array('placeholder' => 'Local Model2 Name'));
    echo $this->Form->file('選択ファイル2');//ファイル選択
    }
    echo $this->Form->end();

?>