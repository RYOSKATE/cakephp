<style type="text/css">
<!--
th {text-align: right;}
-->
</style>

        <?php $ori = array(
			1=>'o1',
			2=>'o12',
			3=>'o2',
			4=>'o13', 
			5=>'o123',
			6=>'o23',
			7=>'o3',
		);
        
		$oriColor = array(
			0 => '#C869FF',//紫
			1 => '#6BCDFF',//水
			2 => '#71FD5E',//緑
			3 => '#FECA61',//黄
			4 => '#FA6565',//赤
			5 => '#000000',//黒
			6 => '#DDDDDD',//灰
        );
		$layer = array( 
			0=>__('アプリケーション(APP)'),
			1=>__('アプリケーションフレームワーク(FW)'),
			2=>__('ライブラリ(外部OSS)'),
			3=>__('Android Runtinme(SYSTEM)'), 
			4=>__('HWライブラリ'),
			5=>__('Kernel'),
			//5=>__('Kernel/ドライバ/ブードローダー'),
			6=>__('Others'),
		);
		
		$metricsSum = array(0,0,0,0,0,0,0,0);
        ?>
<table class="table table-condensed" id ="table">
        <thead>
        <tr>
			<th align="left"><?php echo __('機能レイヤ');?></th>
			<?php 
			for($i=1;$i<=7;++$i)
			{?>
				<th align="right"><?php echo $ori[$i];?></th>
			<?php
			}?>
			<th align="left"><?php echo __('合計値');?></th>
        </tr>
        </thead>
        <tbody>
        <?php 
		for($i=0;$i<=6;++$i)//レイヤー
		{
        ?>
		<tr>
			<td bgcolor=<?php echo $oriColor[$i];?>>
				<?php if($i==5){?>
					<font color="white">
				<?php }?>
				<?php echo $layer[$i];?>
				<?php if($i==5){?>
					</font>
				<?php }?>
			</td>
			<?php 
			$leyarSum = 0;
			for($j=1;$j<=7;++$j)//由来
			{
				?><td align="right"><?php
				if($data)
				{
					$value = $data[$j]['layerHeight'][$i];
					$metricsSum[$j] += $value;
					$leyarSum += $value;
					echo $value;
				}
				?>
				</td>
				<?php
			}
			?>
			<td align="right"><?php echo $leyarSum;?>
			</td>
        </tr>
        <?php 
		}
        ?>
		<tr>
		<td><?php echo __('メトリクス合計値');?></td>
			<?php 
			$leyarSum = 0;
			for($j=1;$j<=7;++$j)//由来
			{
				?><td align="right"><?php
					$leyarSum += $metricsSum[$j];
					echo $metricsSum[$j];
				?>
				</td>
				<?php
			}
			?>
			<td align="right"><?php echo $leyarSum;?>
		</tr>
		<tr>
		<td><?php echo __('合計ファイル数');?></td>
			<?php 
			$leyarSum = 0;
			for($j=1;$j<=7;++$j)//由来
			{
				?><td align="right"><?php
				if($data)
				{
					$leyarSum += $data[$j]['numOfFiles'];
					echo $data[$j]['numOfFiles'];
				}
				?>
				</td>
				<?php
			}
			?>
			<td align="right"><?php echo $leyarSum;?>
		</tr>		
        </tbody>
</table>