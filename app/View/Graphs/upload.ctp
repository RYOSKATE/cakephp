<div class="row">

<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
  <li class="active">ファイルアップロード</a></li>
</ol>

<div class="options form">

<?php echo $this->Form->create('Graph', array
    (
        'inputDefaults' => array
        (     
                'div'       => 'form-group',
                'label'     => array('class' => 'col col-md-3 control-label'),
                'wrapInput' => 'col col-md-7',
                'class'     => 'form-control',
        ),
        'class'   => 'well form-horizontal',
        'enctype' => 'multipart/form-data',
    )); 
?>    
    <fieldset>
        <legend>データのアップロード</legend>
    <?php
        echo $this->Form->text('addModelName');
        echo $this->Form->input('modelName',array
        (
            'type'=>'select',
            'options'=>$modelName,
             'style' => 'width: 200px',
             'onchange' => 'submit(this.form)'
            //'style' => 'width:200px;',
            //'selected' => $selected,  // 規定値をvalueで指定
            // 'div' => false           // div親要素の有無(true/false)
            // 'size' => 1,          // 高さ設定(リストボックスとして表示)
            //'empty' => false,          // 空白を許可
            //'div'   => 'col col-md-6 col-md-offset-2',
            //'class' => 'btn btn-lg btn-primary',
            )
        );//モデル名コンボボックス
        echo $this->Form->file('result');//ファイル選択
    ?>
    </fieldset>

    <?php echo $this->Form->end('アップロード', array
        (
        'div'   => 'col col-md-6 col-md-offset-2',
        'class' => 'btn btn-lg btn-primary',
        'style' => 'padding:8px 20px;'
        ));//アップロードボタン
    ?>

</div>

</div>
