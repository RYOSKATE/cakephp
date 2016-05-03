<?php if($userData['role']!='reader')
{?>
    <div class="row">

    <ol class="breadcrumb">
    <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
    <li class="active">ファイルアップロード</a></li>
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
            <legend>データのアップロード</legend>
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
                'label' => '新規モデル名',
                'placeholder' => 'Input New Model Name',
                'style'=>"width:100%;",
            ));
            echo '</div><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
            echo $this->Form->input('date', array(
                'type'=>'date',
                'label'=>'データ取得日',
                'dateFormat' => 'YMD',
                'monthNames' => false,
                'maxYear' => date('Y'),
                'minYear' => 2010,
                'separator' => '/',
                'style'=>"margin: 10px;",
                )
            );
            echo '</div>';
            echo '<div class="col-md-12 col-sm-12">';
            echo $this->element('localCSV',array("formname" => '選択ファイル'));
            echo '</div>';
            echo '<div class="col-md-12 col-sm-12">';
            echo $this->Form->input('comment', array
            (
                'id'=> 'textarea',
                'label'=>'コメント',
                'type'=>'textarea',
                'placeholder' => 'コメント(任意)',
                'style'=>"width:100%;",
            ));
            echo '</div>';
            echo '<div class="col-md-12 col-sm-12">';
            echo $this->Form->input('アップロード', array
            (
                'label'=>"　",
                'name'=>'set',
                'type'=>'submit',
                'onchange' => 'submit(this.form)',
                'style'=>"width:100%;",
                'class' => 'form-control'
            ));
            echo '</div>';
            echo $this->Form->end();
        ?>
 </div>
        </fieldset>
        <br>
    </div>
    注)同じ日付のデータはアップロードできません。
    <br>
    上書きが必要な場合は以下の履歴から削除してください。
    </div>
<?php
}else{

}?>

<table cellpadding="0" cellspacing="0" class="table table-hover table-condensed">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('date'); ?></th>
			<th><?php echo $this->Paginator->sort('modelname_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo 'comment'; ?></th>
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
		<?php if($userData['role']=='admin'){?>
			<td class="actions">
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'upload_data','action' => 'delete', $uploadData['UploadData']['id']), array(), __('Are you sure you want to delete # %s?', $uploadData['UploadData']['id'])); ?>
			</td>
		<?php }?>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
<?php if($userData['role']=='admin'){?>
<h3><?php echo $this->Html->link('more...',array('controller' => 'upload_data', 'action' => 'index'));?></h3>
<?php }?>