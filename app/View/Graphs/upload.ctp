<?php if($userData['role']!='reader')
{?>
    <div class="row">

    <ol class="breadcrumb">
    <li><?php echo $this->Html->link(__('Home'),array('controller' => 'graphs', 'action' => 'index'));?></li>
    <li class="active"><?php echo __('ファイルアップロード');?></a></li>
    </ol>

    <div class="options form">

    <?php echo $this->Form->create('Graph', array(
        'inputDefaults' => array(
            //'div' => 'form-group',
            'wrapInput' => false,
            'class' => 'form-control'
        ),
        'class' => 'well form-inline',
        'enctype' => 'multipart/form-data',
    )); 
    ?>
        <fieldset>
            <legend><?php echo __('データのアップロード');?></legend>
        <?php

echo '<div class="row">';
            echo '<div class="col-sm-5 col-md-5 col-lg-6">';
            echo $this->Form->input('モデル名',array
            (
                'type'=>'select',
                'options'=>$modelName,
                'empty' => true,
                'style'=>"width:100%;",
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
            echo '</div><div class="col-sm-6 col-md-6 col-lg-6">';
            echo $this->Form->input('新規モデル名', array
            (
                'label' => __('新規モデル名'),
                'placeholder' => 'Input New Model Name',
                'style'=>"width:100%;",
            ));
            echo '</div><div class="col-sm-12 col-md-6 col-lg-6">';
            echo $this->Form->input('date', array(
                'type'=>'date',
                'value'=>date("Y-m-d"),
                'label'=>__('データ取得日'),
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'maxYear' => date('Y'),
                'minYear' => 2010,
                'separator' => '/',
                'style'=>"margin: 10px;",
                )
            );
            echo '</div>';
            
            echo '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">';
            echo $this->Form->input( 'code_check', array( 
                'type' => 'checkbox',
                'checked' => true,    // 初期表示で選択させる場合
                'label' => __('文字コード(UTF-8)チェック'),    // チェックボックスのラベル
                'style'=>"margin: 10px;",
                // 'style'=>"width:100%;",
                // 'div'=>'form-group',
            ));
            // echo $this->Form->input( 'groupcol', array( 
            //     'id'=> 'groupcol',
            //     'type' => 'number',
            //     'label' => __('開発グループ列(zero-based)'),    // チェックボックスのラベル
            //     'step'=>1,
            //     'min'=>-1,
            //     'value'=>1,
            // ));
            echo '</div>';
            echo '<div class="col-md-12 col-sm-12">';
            echo $this->element('localCSV',array("formname" => 'selectCSV'));
            echo '</div>';
            echo '<div class="col-md-12 col-sm-12">';
            echo $this->Form->input('comment', array
            (
                'id'=> 'textarea',
                'label'=>__('コメント'),
                'type'=>'textarea',
                'placeholder' => __('コメント(任意)'),
                'style'=>"width:100%;",
            ));
            echo '</div>';
            echo '<div class="col-md-12 col-sm-12">';
            echo $this->Form->input(__('アップロード'), array
            (
                'label'=>"　",
                'name'=>'set',
                'type'=>'submit',
                'onchange' => 'submit(this.form)',
                'style'=>"width:100%;",
            ));
            echo '</div>';
            echo $this->Form->end();
        ?>
 </div>
        </fieldset>
        <br>
    </div>
<h4><?php echo __('csvファイルフォーマット');?></h4>
<ul>
    <?php echo __('
        <li>対応フォーマット:CSV(utf8)</li>
        <li>ヘッダー行、インデックス列なし</li>
        <li>0列目:ファイルパス</li>
        <li>1列名~(n-1)列目,:メトリクス</li>
        <li>n列目:グループ名(セミコロン区切り)
        <li>例:<code>root/header/function.hpp,1,2,0.837,header,3,AndroidPF;Camera;</code></li>
    ');?>
</ul>
<h4><?php echo __('アップロード時の注意');?></h4>
<ul>
    <?php echo __('
        <li>既存のモデル名を選択、あるいは新規モデル名を入力してください</li>
        <li>モデル名・日付が同じデータはアップロードできません。上書きが必要な場合は以下の履歴から削除してください。</li>
        <li>CSVファイル中のグループ名はUTF-8に変換しアップロードします。<br>「文字コードチェック」オプションは正しく変換できたかチェックを行い、文字化けの可能性がある場合は処理を中断します。</li>
        <li>アップロードには数十秒から数分かかります。画面上部にメッセージが表示されるまでページを移動しないでください。</li>
    ');?>
</ul>

    <br>
    </div>
<?php
}?>

<h3><?php echo __('Upload History'); ?></h3>
<table cellpadding="0" cellspacing="0" class="table table-hover table-condensed">
	<thead>
	<tr>
			<th><?php echo __('id'); ?></th>
			<th><?php echo __('date'); ?></th>
			<th><?php echo __('modelname_id'); ?></th>
			<th><?php echo __('user_id'); ?></th>
			<th><?php echo __('comment'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($uploadData as $uploadData): ?>
	<tr>
		<td><?php echo h($uploadData['UploadData']['id']); ?>&nbsp;</td>
		<td><?php echo h($uploadData['UploadData']['date']); ?>&nbsp;</td>
		<td>
			<?php //echo $this->Html->link($uploadData['Modelname']['name'], array('controller' => 'modelnames', 'action' => 'view', $uploadData['Modelname']['id'])); ?>
			<?php echo h($uploadData['Modelname']['name']); ?>&nbsp;
		</td>
		<td>
			<?php //echo $this->Html->link($uploadData['User']['username'], array('controller' => 'users', 'action' => 'view', $uploadData['User']['id'])); ?>
			<?php echo h($uploadData['User']['username']); ?>&nbsp;
		</td>
		<td><?php echo h($uploadData['UploadData']['comment']); ?>&nbsp;</td>
		<?php if($userData['role']=='admin' || $uploadData['User']['id']==$userData['id']){?>
			<td class="actions">
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'upload_data','action' => 'delete', $uploadData['UploadData']['id']), array(), __('Are you sure you want to delete # %s?', $uploadData['UploadData']['id'])); ?>
			</td>
		<?php }?>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
<h3><?php echo $this->Html->link('more...',array('controller' => 'upload_data', 'action' => 'index'));?></h3>