<h4><?php echo $name;?></h4>
    <table class="table table-hover table-condensed" id ="table">
        <thead>
        <tr>
            <th>由来</th>
            <th><?php echo $metricsName;?></th>
        </tr>
        </thead>
        <tbody>
        <?php $ori = array( 1=>'o1',
                              2=>'o12',
                              3=>'o2',
                              4=>'o13', 
                              5=>'o123',
                              6=>'o23',
                              7=>'o3',
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
			<td id="a"><?php echo $ori[$key];?></td>
            <td><?php echo $value;?></td>
        </tr>
        <?php 
				}
			}
        }?>
        </tbody>
    </table>
