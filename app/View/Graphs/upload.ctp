<?php if($userData['role']!='reader'){?>
<div class="row">

<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
  <li class="active">ファイルアップロード</a></li>
</ol>

<div class="options form">

<?php echo $this->Form->create('Graph', array(
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


        echo $this->Form->input('モデル名',array
        (
            'type'=>'select',
            'options'=>$modelName,
            'empty' => true,
            // 'onchange' => 'submit(this.form)',
             'label'=>array('class' => 'control-label'),
            //'style' => 'width:200px;',
            //'selected' => $selected,  // 規定値をvalueで指定
            // 'div' => false           // div親要素の有無(true/false)
            // 'size' => 1,          // 高さ設定(リストボックスとして表示)
            //'empty' => false,          // 空白を許可
            //'div'   => 'col col-md-6 col-md-offset-2',
            //'class' => 'btn btn-lg btn-primary',
            )
        );//モデル名コンボボックス
        echo ' or ';
        echo $this->Form->input('新規モデル名', array
        (
            'placeholder' => 'Input New Model Name',
        ));
        echo '<br>';
        echo $this->Form->input('comment', array
        (
            'id'=> 'textarea',
            'label'=>'コメント',
            'type'=>'textarea',
            'placeholder' => 'comment',
        ));
        echo '<br>';
        echo $this->Form->input('date', array(
            'type'=>'date',
            'label'=>'データ取得日',
            'dateFormat' => 'YMD',
            'monthNames' => false,
            'maxYear' => date('Y'),
            'minYear' => date('Y') - 100,
            )
        );
        echo $this->Form->input('選択ファイル', array
        (
            'type' => 'file',
            'label'=>'CSVファイル選択',
        ));
    ?>
    </fieldset>

    <?php echo $this->Form->end('アップロード', array
        (
        'div'   => 'col col-md-6 col-md-offset-2',
        'class' => 'btn btn-lg btn-primary',
        'style' => 'padding:8px 20px;',
        ));//アップロードボタン
    ?>

</div>
注)同じ日付のデータはアップロードできません。
<br>
上書きが必要な場合は以下の履歴ページから削除してください。
<h1><?php echo $this->Html->link('Upload History',array('controller' => 'upload_data', 'action' => 'index'));?></h1>
</div>
<?php
}else
{
    //ここを何とか表示したい
    echo $this->Session->flash('good');
}
     echo $this->Session->Flash(__('モデル名が入力されていません<button class="close" data-dismiss="alert">&times;</button>'), 'default', array('class'=> 'alert alert-danger alert-dismissable'));

?>