<?php 
	echo $this->Form->input('可視化手法',array
	(
	    'type'=>'select',
	    'options'=>$methods,
		'label'=>__('他の可視化手法に変更'),
	    // 'style' => 'width: 200px',
	    // 'onchange' => 'submit(this.form)',
	    //'selected' => $selected,  // 規定値をvalueで指定
	    // 'div' => false           // div親要素の有無(true/false)
	    // 'size' => 1,          // 高さ設定(リストボックスとして表示)
	    'empty' => true,          // 空白を許可
	    //'div'   => 'list-group nav nav-tabs nav-stacked fixed-sidebar',
		'style'=>"width:100%;",
	    'class' => 'form-control'
	 ));
?> 