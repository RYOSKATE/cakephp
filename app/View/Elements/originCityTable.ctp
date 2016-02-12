<h4><?php echo $name;?></h4>
    <table class="table table-condensed" id ="table">
        <thead>
        <tr>
			<th> 色 </th>
            <th>由来</th>
            <th><?php echo $metricsName;?></th>
        </tr>
        </thead>
        <tbody>
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
        <?php 
        if(!empty($data))
        {
			foreach($data as $key => $value)
			{
				if(0<$value)
				{
        ?>
		<tr>
			<td id="a" bgcolor=<?php echo $oriColor[$key];?>></td>
			<td><?php echo $ori[$key];?></td>
            <td><?php echo $value;?></td>
        </tr>
        <?php 
				}
			}
        }?>
        </tbody>
    </table>
<table class="table table-condensed" id ="table">
	<thead>
        <tr>
			<th></th><th></th><th></th><th></th>
            <th>関連領域</th>
            <th><?php echo $metricsName;?></th>
        </tr>
	</thead>
    <tbody>
		<?php $ori = array(
			// 1=>'o1+o12+o13+o123',
			// 2=>'o2+o12+o23+o123',
			// 3=>'o3+o13+o23+o123',
			1=>'google',
			2=>'チップベンダー',
			3=>'富士通',
		);
        ?>
		<tr>
			<td id="a" bgcolor=<?php echo $oriColor[1];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[2];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[4];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[5];?>></td>
			<td><?php echo $ori[1];?></td>
            <td><?php echo $data[1]+$data[2]+$data[4]+$data[5];?></td>
        </tr>
		<tr>
			<td id="a" bgcolor=<?php echo $oriColor[3];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[2];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[6];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[5];?>></td>
			<td><?php echo $ori[2];?></td>
            <td><?php echo $data[2]+$data[3]+$data[5]+$data[6];?></td>
        </tr>
		<tr>
			<td id="a" bgcolor=<?php echo $oriColor[7];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[4];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[6];?>></td>
			<td id="a" bgcolor=<?php echo $oriColor[5];?>></td>
			<td><?php echo $ori[3];?></td>
            <td><?php echo $data[4]+$data[5]+$data[6]+$data[7];?></td>
        </tr>
	</tbody>
</table>
