<?php $this->Html->script('amcharts/serial', array('inline' => false));?>
<?php $this->Html->script('amcharts/amstock', array('inline' => false));?>
<?php $this->Html->script('d3/d3.min', array('inline' => false));?>
<?php
//デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // print_r($model);
    // echo '</pre>';
?>
<style>

path {
  stroke: #fff;
}

path:first-child {
  fill: yellow !important;
}

circle {
  fill: #000;
  pointer-events: none;
}

.q0-9 { fill: rgb(197,27,125); }
.q1-9 { fill: rgb(222,119,174); }
.q2-9 { fill: rgb(241,182,218); }
.q3-9 { fill: rgb(253,224,239); }
.q4-9 { fill: rgb(247,247,247); }
.q5-9 { fill: rgb(230,245,208); }
.q6-9 { fill: rgb(184,225,134); }
.q7-9 { fill: rgb(127,188,65); }
.q8-9 { fill: rgb(77,146,33); }

/*body {
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  margin: auto;
  position: relative;
  width: 960px;
}

form {
  position: absolute;
  right: 10px;
  top: 10px;
}

.node {
  border: solid 1px white;
  font: 10px sans-serif;
  line-height: 12px;
  overflow: hidden;
  position: absolute;
  text-indent: 2px;*/
}
</style>
<form>
  <label><input type="radio" name="mode" value="size" checked> Size</label>
  <label><input type="radio" name="mode" value="count"> Count</label>
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
<script>
    var width = 700;
    var height = 600;
 
    var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height)
    .attr("transform","translate(50,50)");
 
    var color10 = d3.scale.category10();
 
    // ツリーマップの設定。
    var treemap = d3.layout.treemap()
    .size([width, height - 100])
    .value(value) // 値の名前を指定。
    .children(children); // 入れ子の名前を指定。
 
    function value(d) {
      return d["好き度"];
    }
 
    function children(d) {
      return d["種類"];
    }
 
 	var data =JSON.parse('<?=json_encode($tree);?>');
    // d3.json("kinoko_takenoko.json", function(data) {
 
// x,y,dx,dy,area,depthが出る。
	//data = data.slice();
var areas = treemap.nodes(data);
 
    //console.log(areas);
 
    var cells = svg.selectAll(".cell")
    .data(areas)
    .enter()
    .append("g")
    .attr("class","cell");
 
    cells.append("rect")
    .attr("x", function(d){ return d.x; })
    .attr("y", function(d){ return d.y; })
    .attr("width", function(d){ return d.dx; })
    .attr("height", function(d){ return d.dy; })
    .attr("fill",function(d){ return d.children ? null : color10(d.parent.name); }) // 一番下の子だけ親に合わせて色を変える。
    .attr("stroke", "white")
    .attr("stroke-width",2)
    .attr("opacity", 1); // 重なった円が見えるように透明度をつける。
 
    cells.append("text")
    .attr("x", function(d){ return d.x + (d.dx/2); }) // 各rectの真ん中に配置。
    .attr("y", function(d){ return d.y + (d.dy/2); }) // 各rectの真ん中に配置。
    .attr("text-anchor","middle")
    .text(function(d){ return d.children ? "" : d.name; }) // 一番下の子の名前だけ表示。
    .attr("stroke", "black");
 
    //});
 
    </script>
<script type="text/javascript">
	
	var width = 960,
    height = 500;
var vertices = d3.range(100).map(function(d) {
  return [Math.random() * width, Math.random() * height];
});

var voronoi = d3.geom.voronoi()
    .clipExtent([[0, 0], [width, height]]);

var svg = d3.select("body").append("svg")
    .attr("width", width)
    .attr("height", height)
    .on("mousemove", function() { vertices[0] = d3.mouse(this); redraw(); });

var path = svg.append("g").selectAll("path");

svg.selectAll("circle")
    .data(vertices.slice(1))
  .enter().append("circle")
    .attr("transform", function(d) { return "translate(" + d + ")"; })
    .attr("r", 1.5);

redraw();

function redraw() {
  path = path
      .data(voronoi(vertices), polygon);

  path.exit().remove();

  path.enter().append("path")
      .attr("class", function(d, i) { return "q" + (i % 9) + "-9"; })
      .attr("d", polygon);

  path.order();
}

function polygon(d) {
  return "M" + d.join("L") + "Z";
}

</script>
<script type="text/javascript">
	//data[0][0]["GroupData"]   ["defact_num"]/[group_name]/ [file_num]/[file_num]/[loc]/[date] ;
	//	  1-4[日付分]
	var data = new Array();
	data.push(JSON.parse('<?=json_encode($data1);?>'));
	data.push(JSON.parse('<?=json_encode($data2);?>'));
	data.push(JSON.parse('<?=json_encode($data3);?>'));
	data.push(JSON.parse('<?=json_encode($data4);?>'));

	var modelName = JSON.parse('<?=json_encode($model);?>');
	AmCharts.ready(function () 
	{
		generateChartData();
		createStockChart();
	});

	var chartData = new Array();
	function generateChartData() 
	{
		var date = data[0][0]['GroupData']['date'];
		var firstDate = new Date(date);

		for(var i =0;i<data.length;++i)
		{
			var chartDataTemp = [];
			for(var j =0;j<data[i].length;++j)
			{
				var dataTemp = data[i][j]['GroupData'];
				chartDataTemp.push({
					date: dataTemp['date'],
					value: dataTemp['defact_num'],
					volume: 0
				});
			}
			chartData.push(chartDataTemp);
		}
	}

	function createStockChart() 
	{
		var chart = new AmCharts.AmStockChart();
		chart.pathToImages = "http://www.amcharts.com/lib/3/images/";///ファイルパスの設定要確認
		// DATASETS //////////////////////////////////////////
		// create data sets first
		var dataSet = new Array();
		for(var i =0;i<chartData.length;++i)
		{
			var dataSetTemp = new AmCharts.DataSet();
			dataSetTemp.title = modelName[i+1];//選択されたモデル名に変更する必要あり
			dataSetTemp.fieldMappings = [{
					fromField: "value",
					toField: "value"
				}, {
					fromField: "volume",
					toField: "volume"
			}];
			dataSetTemp.dataProvider = chartData[i];
			dataSetTemp.categoryField = "date";
			dataSet.push(dataSetTemp);
		}

		// set data sets to the chart
		chart.dataSets = dataSet;

		// PANELS ///////////////////////////////////////////
		// first stock panel
		var stockPanel1 = new AmCharts.StockPanel();
		stockPanel1.showCategoryAxis = false;
		stockPanel1.title = "Value";
		stockPanel1.percentHeight = 70;

		// graph of first stock panel
		var graph1 = new AmCharts.StockGraph();
		graph1.valueField = "value";
		graph1.comparable = true;
		graph1.compareField = "value";
		graph1.bullet = "round";
		graph1.bulletBorderColor = "#FFFFFF";
		graph1.bulletBorderAlpha = 1;
		graph1.balloonText = "[[title]]:<b>[[value]]</b>";
		graph1.compareGraphBalloonText = "[[title]]:<b>[[value]]</b>";
		graph1.compareGraphBullet = "round";
		graph1.compareGraphBulletBorderColor = "#FFFFFF";
		graph1.compareGraphBulletBorderAlpha = 1;
		stockPanel1.addStockGraph(graph1);

		// create stock legend
		var stockLegend1 = new AmCharts.StockLegend();
		stockLegend1.periodValueTextComparing = "[[percents.value.close]]%";
		stockLegend1.periodValueTextRegular = "[[value.close]]";
		stockPanel1.stockLegend = stockLegend1;

		// set panels to the chart
		chart.panels = [stockPanel1];


		// OTHER SETTINGS ////////////////////////////////////
		var sbsettings = new AmCharts.ChartScrollbarSettings();
		sbsettings.graph = graph1;
		chart.chartScrollbarSettings = sbsettings;

		// CURSOR
		var cursorSettings = new AmCharts.ChartCursorSettings();
		cursorSettings.valueBalloonsEnabled = true;
		chart.chartCursorSettings = cursorSettings;


		// PERIOD SELECTOR ///////////////////////////////////
		var periodSelector = new AmCharts.PeriodSelector();
		periodSelector.position = "left";
		periodSelector.periods = [{
			period: "DD",
			count: 10,
			label: "10 days"
		}, {
			period: "MM",
			selected: true,
			count: 1,
			label: "1 month"
		}, {
			period: "YYYY",
			count: 1,
			label: "1 year"
		}, {
			period: "YTD",
			label: "YTD"
		}, {
			period: "MAX",
			label: "MAX"
		}];
		chart.periodSelector = periodSelector;


		// DATA SET SELECTOR
		var dataSetSelector = new AmCharts.DataSetSelector();
		dataSetSelector.position = "left";
		chart.dataSetSelector = dataSetSelector;
		chart.write('chartdiv');
	}
</script>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
  <li class="active">開発グループ</a></li>
  <li class="active">各開発グループ</li>
</ol>

<div class="page-header">
<?php 
  //   echo $this->Form->create('Graph',array('inputDefaults' => 
  //                                       array('div' => 'form-group',),
  //                                       'class' => 'well form-inline',
  //                                       )
  //                           );
  //   for($i=1;$i<=4;++$i)
  //   {
  //   	echo $this->Form->input('モデル'.$i,array
		// (
		//     'type'=>'select',
		//     'options'=>$modelName,
		//     'class' => 'form-control'
		//  ));
  //   }
  //   echo $this->element('selectGroup',$groupName); 
  //   echo $this->Form->end('セット', array
  //   (
  //   'class' => 'form-control'
  //   ));


?>
</div>

<!-- <div id="chartdiv" style="height:600px;"></div> -->