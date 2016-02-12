<h4><?php echo $name;?></h4>
    <table class="table table-condensed" id ="table">
        <thead>
        <tr>
			<th>色</th>
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
			<!--<td id="a" bgcolor="#FF0000"></td>-->
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
