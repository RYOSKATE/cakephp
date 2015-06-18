<div>
	<?php 
		echo $this->Form->input('モデル',array
		(
		    'type'=>'select',
		    'options'=>$modelName,
		    // 'style' => 'width: 200px',
		     'onchange' => 'submit(this.form)',
		    //'selected' => $selected,  // 規定値をvalueで指定
		    // 'div' => false           // div親要素の有無(true/false)
		    // 'size' => 1,          // 高さ設定(リストボックスとして表示)
		    //'empty' => false,          // 空白を許可
		    //'div'   => 'list-group nav nav-tabs nav-stacked fixed-sidebar',
		    'class' => 'form-control'
		 ));
	?> 
</div>