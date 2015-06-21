<?php
/*echo '<pre>';
print_r($data);
echo '</pre>';*/
?>
<?php $this->Html->script('amcharts/Chart.Core', array('inline' => false));?>
<?php $this->Html->script('amcharts/Chart.Radar', array('inline' => false));?>

<!-- Radar chart-->
<script type="text/javascript">

var radarChartData = {
    labels: ["アプリケーション", "アプリケーションフレームワーク", "ライブラリ(外部OSS)", "Android Runtime", "HWライブラリ", "Kernel/ドライバ/ブートローダー"],
    datasets: [
        {
            label:<?php echo "'".$data[0]['ModelLayer']['model']."'";?>,
            fillColor: "rgba(255,102,0,0.2)",
            strokeColor: "rgba(255,102,0,1)",
            pointColor: "rgba(255,102,0,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(255,102,0,1)",
            data: [65,59,90,81,56,55]
        },
        {
            label: <?php echo "'".$data[0]['ModelLayer']['model']."'";?>,
            fillColor: "rgba(252,210,2,0.2)",
            strokeColor: "rgba(252,210,2,1)",
            pointColor: "rgba(252,210,2,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(252,210,2,1)",
            data: [28,48,40,19,96,27]
        }
    ]
};

window.onload = function(){
    window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {
        responsive: true
    });
}
</script>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
  <li class="active">モデル</a></li>
  <li class="active">メトリクス比較</li>
</ol>

<div class="page-header">
  <h1><small>メトリクス比較</small></h1><p><?php echo $data[0]['ModelLayer']['model'];?></p>
</div>

<div class="row">
    <div class="col-md-6 col-sm-6">
        <canvas id="canvas" height="450" width="450"></canvas>
    </div>
    <div class="col-md-6 col-sm-6" >
	<h4><?php echo $data[0]['ModelLayer']['model'];?></h4>
	<table class="table table-hover table-condensed">
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
		<?php $layer = array(1 => 'アプリケーション',2=>'アプリケーションフレームワーク',3=>'ライブラリ(外部OSS)',4=>'Android Runtinme', 5=>'HWライブラリ',6=>'Kernel/ドライバ/ブードローダー');?>
		<?php foreach($data as $key => $value){
			$val = $value['ModelLayer']?>
		<tr>
			<td><?php echo $layer[$val['layer']];?></td>
			<td><?php echo $val['all_file_num'];?></td>
			<td><?php echo $val['defect_file_num'];?></td>
			<td><?php echo sprintf("%.2f",$val['defect_file_num']/$val['all_file_num']*100);?></td>
			<td><?php echo $val['defect_num'];?></td>
		</tr>
		<?php }?>
		</tbody>
	</table>



	<?php if(isset($data2) && $data2 !=NULL) { ?>
	<h4><?php echo $data2[0]['ModelLayer']['model'];?></h4>
	<table class="table table-hover table-condensed">
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
			<td><?php echo sprintf("%.2f",$val['defect_file_num']/$val['all_file_num']*100);?></td>
			<td><?php echo $val['defect_num'];?></td>
		</tr>
		<?php }?>
		</tbody>
	</table>
	<?php } ?>

    </div>
</div>
