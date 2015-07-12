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
?>    
<fieldset>
    <legend>データのアップロード</legend>
<?php
    echo $this->Form->input('モデル名', array('placeholder' => 'New Model Name'));
    //echo $this->Form->text('addModelName');
     //echo $this->Form->end();
    echo $this->Form->file('選択ファイル');//ファイル選択
?>
</fieldset>

<?php 
	echo $this->Form->end('表示', array
    (
    'div'   => 'col col-md-6 col-md-offset-2',
    'class' => 'btn btn-lg btn-primary',
    'style' => 'padding:8px 20px;',
    ));//アップロードボタン
?>
