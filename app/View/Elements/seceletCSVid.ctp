<?php 
	//$formname :'CSV_ID1'
	//$isAllowEmpty:
	echo $this->Form->input($formname,array
	(
	    'type'=>'select',
	    'options'=>$uploadList,
		// 'style' => 'width: 200px',
	    // 'onchange' => 'submit(this.form)',
	    //'selected' => $selectMetrics,  // 規定値をvalueで指定
	    // 'div' => false           // div親要素の有無(true/false)
	    // 'size' => 1,          // 高さ設定(リストボックスとして表示)
	    'empty' => $isAllowEmpty,          // 空白を許可
	    //'div'   => 'list-group nav nav-tabs nav-stacked fixed-sidebar',
	    'class' => 'form-control',
	 ));
?> 