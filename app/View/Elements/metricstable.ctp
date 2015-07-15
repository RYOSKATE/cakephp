<h4><?php echo $name;?></h4>
    <table class="table table-hover table-condensed" id ="table">
        <thead>
        <tr>
            <th>機能レイヤ</th>
            <th>ファイル数</th>
            <th>欠陥ファイル数</th>
            <th>欠陥ファイル率</th>
            <th>欠陥数</th>
        </tr>
        </thead>
        <tbody>
        <?php $layer = array( 0=>'アプリケーション(APP)',
                              1=>'アプリケーションフレームワーク(FW)',
                              2=>'ライブラリ(外部OSS)',
                              3=>'Android Runtinme(SYSTEM)', 
                              4=>'HWライブラリ',
                              5=>'Kernel',
                              //5=>'Kernel/ドライバ/ブードローダー',
                              6=>'Others',
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
