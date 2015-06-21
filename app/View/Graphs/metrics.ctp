<?php
/*echo '<pre>';
print_r($data1);
echo '</pre>';*/
?>
<?php $this->Html->script('amcharts/Chart.Core', array('inline' => false));?>
<?php $this->Html->script('amcharts/Chart.Radar', array('inline' => false));?>

<!-- Radar chart-->
<script type="text/javascript">

	var radarChartData;

	function setdata(showParam)
	{
		var dataset1 = JSON.parse('<?=json_encode($data1);?>');
		var dataset2 = JSON.parse('<?=json_encode($data2);?>');
		for( var i  = 0; i < dataset1.length; ++i )
		{
			dataset1[i]=dataset1[i]['ModelLayer'][showParam];
			dataset2[i]=dataset2[i]['ModelLayer'][showParam];
		}
		var radarChartData = {
		    labels: [
		    		 "アプリケーション", 
				     "アプリケーションフレームワーク",
				     "ライブラリ(外部OSS)", 
				     "Android Runtime", 
				     "HWライブラリ", 
				     "Kernel/ドライバ/ブートローダー"
			],
		    datasets: [
		        {
		            label:<?php echo "'".$data1[0]['ModelLayer']['model']."'";?>,
		            fillColor: "rgba(255,102,0,0.2)",
		            strokeColor: "rgba(255,102,0,1)",
		            pointColor: "rgba(255,102,0,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(255,102,0,1)",
		            data: dataset1
		        },
		        {
		            label: <?php echo "'".$data1[0]['ModelLayer']['model']."'";?>,
		            fillColor: "rgba(252,210,2,0.2)",
		            strokeColor: "rgba(252,210,2,1)",
		            pointColor: "rgba(252,210,2,1)",
		            pointStrokeColor: "#fff",
		            pointHighlightFill: "#fff",
		            pointHighlightStroke: "rgba(252,210,2,1)",
		            data: dataset2
		        }
		    ]
		};
		return radarChartData;
	}
	
	radarChartData = setdata('all_file_num');

	window.onload = function(){
	    window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {responsive: true});
	}

	// JavaScript
	//  イベントハンドラ
	$('#table td').live('click',function(){
	  var $cur_td = $(this)[0]; // (1):セルのHTML表現 [0]をつける点に留意のこと。  
	  var $cur_tr = $(this).parent()[0]; // (2):行のHTML表現
	  // $cur_tr = $(this).closest('tr')[0]; // このほうが確実
	  var $select = $cur_td.cellIndex;
	  var $param = 'all_file_num';
	  switch($select)
	  {
	      case 1 : $param = 'all_file_num'; break;
	      case 2 : $param = 'defect_file_num'; break;
	      case 3 : $param = 'defect_per_file'; break;
	      case 4 : $param = 'defect_num'; break;
	      default :
	  }
	  radarChartData = setdata($param);
	  window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {responsive: true});
	});
</script>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
  <li class="active">モデル</a></li>
  <li class="active">メトリクス比較</li>
</ol>

<div class="page-header">
  <h1><small>メトリクス比較</small></h1>
    <?php 
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                        array('div' => 'form-group',),
                                        'class' => 'well form-inline',
                                        )
                            );

    echo $this->Form->input('モデル1',array
    (
        'type'=>'select',
        'options'=>$modelName,
        'class' => 'form-control'
     ));
    echo $this->Form->input('モデル2',array
    (
        'type'=>'select',
        'options'=>$modelName,
        'class' => 'form-control'
     ));
    echo $this->element('selectGroup',$groupName); 
    echo $this->Form->end('セット', array
    (
    'class' => 'form-control'
    ));

?>
</div>

<div class="row">
    <div class="col-md-8 col-sm-8">
        <canvas id="canvas" height="200" width="450"></canvas>
    </div>
    <div class="col-md-9 col-sm-9" >
	<h4><?php echo $name1;?></h4>
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
		<?php $layer = array( 0=>'アプリケーション',
							  1=>'アプリケーションフレームワーク',
							  2=>'ライブラリ(外部OSS)',
							  3=>'Android Runtinme', 
							  4=>'HWライブラリ',
							  5=>'Kernel/ドライバ/ブードローダー');
		?>
		<?php foreach($data1 as $key => $value)
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
		}?>
		</tbody>
	</table>

	<?php if(isset($data2) && $data2 != NULL) { ?>
	<h4><?php echo $name2;?></h4>
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
		<?php foreach($data2 as $key => $value){
			$val = $value['ModelLayer']?>
		<tr>
			<td><?php echo $layer[$val['layer']];?></td>
			<td><?php echo $val['all_file_num'];?></td>
			<td><?php echo $val['defect_file_num'];?></td>
			<td><?php echo sprintf("%.2f",$val['defect_per_file']);?></td>
			<td><?php echo $val['defect_num'];?></td>
		</tr>
		<?php }?>
		</tbody>
	</table>
	<?php } ?>

    </div>
</div>
