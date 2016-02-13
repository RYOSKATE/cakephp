<STYLE type="text/css">
<!--
#S1
{
	filter:alpha(opacity=50);
}
-->
</STYLE>
<h4><?php echo $name;?></h4>
        <?php $ori = array(
			1=>'o1',
			2=>'o12',
			3=>'o2',
			4=>'o13', 
			5=>'o123',
			6=>'o23',
			7=>'o3',
		);
        ?>
		<?php $oriColor = array(		
			0 => '#FFFFFF',//不使用
			1 => '#FA6565',//赤
			2 => '#FECA61',//黄
			3 => '#71FD5E',//緑
			4 => '#C869FF',//紫
			5 => '#DDDDDD',//灰
			6 => '#6BCDFF',//水
			7 => '#0055FF'//青
        );
        ?>
		<?php $oriStr = array(
			// 1=>'o1+o12+o13+o123',
			// 2=>'o2+o12+o23+o123',
			// 3=>'o3+o13+o23+o123',
			1=>'Google',
			2=>'Qualcomm',
			3=>'富士通',
		);
        ?>
		<?php $oriNums= array(
			1=>array(1,2,4,5),
			2=>array(2,3,5,6),
			3=>array(4,5,6,7)
		);
        ?>
		<?php $oriSum= array(
			// 1=>'o1+o12+o13+o123',
			// 2=>'o2+o12+o23+o123',
			// 3=>'o3+o13+o23+o123',
			1=>$data[1]+$data[2]+$data[4]+$data[5],
			2=>$data[2]+$data[3]+$data[5]+$data[6],
			3=>$data[4]+$data[5]+$data[6]+$data[7],
		);
        ?>
<table class="table table-condensed" id ="table">
	<thead>
        <tr>
			<th></th><th></th><th></th><th></th>
            <th>関連領域</th>
            <th><?php echo $metricsName;?></th>
        </tr>
	</thead>
    <tbody>

		<?php
		for($i=1;$i=3;++$i)
		{?>
		<tr>
			<?php
			for($j=0;$j<4;++$j)
			{?>
				<td bgcolor=<?php echo $oriColor[$oriNums[$i][$j]];?>></td>
			<?php
			}?>
			<td><?php echo $oriStr[$i];?></td>
            <td><?php echo $oriSum[$i];?></td>
        </tr>
		<?php
		}?>
	</tbody>
</table>
<table class="table table-condensed" id ="table">
        <thead>
        <tr>
			<th> 　　 </th>
            <th>由来</th>
            <th><?php echo $metricsName;?></th>
			<?php 
			for($i=1;$i<=3;++$i)
			{?>
				<th>/<?php echo $oriStr[$i];?>[%]</th>
			<?php
			}?>
        </tr>
        </thead>
        <tbody>

        <?php 
		for($i=1;$i<8;++$i)
		{
			$value = $data[$i];
			{
        ?>
		<tr>
			<td bgcolor=<?php echo $oriColor[$i];?>></td>
			<td><?php echo $ori[$i];?></td>
            <td><?php echo $value;?></td>
			<?php 
			for($i=j;$j<=3;++$j)
			{
				if(in_array($j,$oriNums))
				{
					?><td><?php
				}
				else
				{
					?><td id="S1"><?php
				}
				echo sprintf("%.2f", 100.0*$value/$oriSum[$j]);
				?>
				</td>
			<?php
			}?>
        </tr>
        <?php 
			}
		}
        ?>
        </tbody>
</table>