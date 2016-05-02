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
    echo '<div class="row">';
    echo '<div class="col-md-6 col-sm-6">';
    echo $this->Form->input('CSV_ID1',array
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
		'empty' => false,
	 ));
     echo '</div>';
     echo '<div class="col-md-6 col-sm-6">';
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
		'empty' => false,
	 ));
     echo '</div>';
    if(isset($useLocalCSV))
    {
    ?><br><?php
     echo '<div class="col-md-6 col-sm-6">';
    echo $this->Form->file('選択ファイル1');//ファイル選択
     echo '</div>';
     echo '<div class="col-md-6 col-sm-6">';
    echo $this->Form->file('選択ファイル2');//ファイル選択
         echo '</div>';
    }
    
echo '<div class="col-md-12 col-sm-12">';
    echo $this->element('selectGroup',$groupName);
    echo $this->element('setButton');
     echo '</div>';
    echo '</div>';
    echo $this->Form->end();

?>