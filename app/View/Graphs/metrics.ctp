<?php
echo '<pre>';
print_r($data[1]);
echo '</pre>';
?>
<?php $this->Html->script('amcharts/Chart.Core', array('inline' => false));?>
<?php $this->Html->script('amcharts/Chart.Radar', array('inline' => false));?>

<!-- Radar chart-->
<script type="text/javascript">

	function getLayer(filepath)
    {
    	return 'アプリケーション';
    }
	var data1 = JSON.parse('<?=json_encode($data);?>');
    var value1 = data1[0]["Graph"]["model"];//モデル名
	var value2 = data1[0]["Graph"]["file_path"];//ファイルパス
    var value3 = data1[0]["Graph"][3];//欠陥数

    var data = new Array();
    for( var i  = 0; i < 6; ++i )
    {
    	data.push({'all_file_num':0, 'defect_file_num' :0, 'defect_num':0 });
    }

    for( var i  = 0; i < data1.length; ++i )
    {
    	var temp = data1[i]["Graph"];
    	var layer = getLayer(temp["file_path"]);
    	var defacts = temp[3];
    	++data[layer]['all_file_num'];
    	data[layer]['defect_num'] += defacts;
    	if(0<defacts)
    	{
    		++data[layer]['defect_file_num'];
    	}
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
            label:<?php echo $modelName1;?>,
            fillColor: "rgba(255,102,0,0.2)",
            strokeColor: "rgba(255,102,0,1)",
            pointColor: "rgba(255,102,0,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(255,102,0,1)",
            data: [65,59,90,81,56,55]
        },
        {
            label: <?php echo $modelName1;?>,
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
  <h1><small>メトリクス比較</small></h1>
</div>
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
<div class="row">
    <div class="col-md-6 col-sm-6">
        <canvas id="canvas" height="450" width="450"></canvas>
    </div>
<!--     <div class="col-md-6 col-sm-6" >
	<h4><?php echo $modelName1;?></h4>
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
	<h4><?php echo $modelName2;?></h4>
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

    </div> -->

<div id ="table"></div>
<script type="text/javascript">
    // 表をつくる関数
    function makeTable(data,divname)
    {
        var tableText=[["機能レイヤ","ファイル数","欠陥ファイル数","欠陥ファイル率","欠陥数"]];
        // 表に表示するテキストデータをまとめる
        var labels = new Array();
        labels.push([
		    "アプリケーション", 
		    "アプリケーションフレームワーク",
		     "ライブラリ(外部OSS)", 
		     "Android Runtime", 
		     "HWライブラリ", 
		     "Kernel/ドライバ/ブートローダー"
     		]);
        for(i=0;i<6;i++)data.push({'all_file_num':0, 'defect_file_num' :0, 'defect_num':0 });
        {
        	var d = data[i];
        	var per = d['all_file_num']/d['defect_file_num'];
            tableText.push([labels[i],d['all_file_num'],d['defect_file_num'],per,d['defect_num']]);
        }

        // 表の作成開始
        var rows=[];
        var colorCode=["#B0C4DE","#FFDAB9"];
        var table = document.createElement("table");
        for(i=0;i<tableText.length;i++)
        {
            // 行の追加
            rows.push(table.insertRow(-1));
            for(j=0;j<4;j++)
            {
                // 追加した行にセルを追加してテキストを書き込む
                cell=rows[i].insertCell(-1);
                cell.appendChild(document.createTextNode(tableText[i][j]));
                // 背景色の設定
                if(i==0)
                {
                    cell.style.backgroundColor=colorCode[0];
                }else if(i>tableText.length-3)
                {
                    cell.style.backgroundColor=colorCode[1];
                }
            }
        }
        // 指定したdiv要素に表を加える
        document.getElementById(divname).appendChild(table);
    }

    // 関数呼び出し
    makeTable(data,"table");
</script>
</div>
