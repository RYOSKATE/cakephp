<h4><?php echo __('モデル名');?>:<?php echo $name;?></h4>
<h6><?php echo __('メトリクス');?>:<?php echo $metricsName;?></h6>
    <table class="table table-hover table-condensed" id ="table">
        <thead>
        <tr>
            <th><?php echo __('機能レイヤ');?></th>
            <th><?php echo __('メトリクス値');?></th>
            <th><?php echo __('ファイル数');?></th>
            <th><?php echo __('欠陥ファイル数');?></th>
            <th><?php echo __('欠陥ファイル率');?></th>
            <th><?php echo __('欠陥数');?></th>
        </tr>
        </thead>
        <tbody>
        <?php $layer = array( 0=>__('アプリケーション(APP)'),
                              1=>__('アプリケーションフレームワーク(FW)'),
                              2=>__('ライブラリ(外部OSS)'),
                              3=>__('Android Runtinme(SYSTEM)'), 
                              4=>__('HWライブラリ'),
                              5=>__('Kernel'),
                              //5=>__('Kernel/ドライバ/ブードローダー'),
                              6=>__('Others'),
                             );
        ?>
        <?php 
        if(!empty($data))
        {
          foreach($data as $key => $value)
          {
              $val = $value['ModelLayer']
          ?>
          <tr>
              <td id="a"><?php echo $layer[$val['layer']];?></td>
              <td><?php echo $val['metrics'];?></td>
              <td><?php echo $val['all_file_num'];?></td>
              <td><?php echo $val['defect_file_num'];?></td>
              <td><?php echo sprintf("%.2f",$val['defect_per_file']);?></td>
              <td><?php echo $val['defect_num'];?></td>
          </tr>
          <?php 
          }
        }?>
        </tbody>
    </table>
