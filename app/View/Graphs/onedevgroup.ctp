<?php $this->Html->script('amcharts/serial', array('inline' => false));?>
<?php $this->Html->script('amcharts/amstock', array('inline' => false));?>
<?php $this->Html->script('d3/d3.min', array('inline' => false));?>
<?php
//デバッグ用表示
    echo 'デバッグ用表示';
    echo '<pre>';
    //print_r($tree);
    echo '</pre>';
?>
<head>
    <script type="text/javascript" src="http://d3js.org/d3.v2.js"></script>
    <style type="text/css">

		rect {
		  fill: none;
		  stroke: #fff;
		}
		
		rect:hover{
			opacity: 0.5;
		}

		text {
			font-family:"Times New Roman",Times,serif;
			font-size: 12px;
		}

    </style>
  </head>
  <body>
  <div id="body"></body>
    <script type="text/javascript">


    //var pathjson = JSON.parse('<?=json_encode($tree);?>');
	var pathJson = {
 	"name": "Sample data",
 	"children": [
        {
           "name": "Title 1",
           "size":1,
           "children": [
                    {
                     "name": "Title 1-1",
                     "size":1,
                     "children": [
                        {"name": "1-1-1", "size": 1},
                        {"name": "1-1-2", "size": 1},
                        {"name": "1-1-3", "size": 1},
                        {"name": "1-1-4", "size": 1}
                      ]
                  },  
                  {
                     "name": "Title 1-2",
                     "size":1,
                     "children": [
                        {"name": "1-2-1", "size": 1},
                        {"name": "1-2-2", "size": 1},
                        {"name": "1-2-3", "size": 1}
                      ]
                  },  
                  {
                     "name": "Title 1-3",
                     "size":1,
                     "children": [
                        {"name": "1-3-1", "size": 1}
                      ]
                  }
               ]
        }
     ]
	}


	pathJson = {
				"name": "Sample data",
 				"children": [{
           					"name": "Title 1",
          					 "size":1
          					}]
          		}
    pathJson = JSON.parse('<?php echo  $tree; ?>');
var w = 1280 - 80,
        h = 800 - 180,
        x = d3.scale.linear().range([0, w]),
        y = d3.scale.linear().range([0, h]),
        color = d3.scale.category10(),
        root,
        node;

        var treemap = d3.layout.treemap()
            .round(false)
            .size([w, h])
            .sticky(true)
            .padding([10, 0, 0, 0])
            .value(function(d) { return d.size; });

        var svg = d3.select("#body").append("div")
            .attr("class", "chart")
            .style("width", w + "px")
            .style("height", h + "px")
          .append("svg:svg")
            .attr("width", w)
            .attr("height", h)
          .append("svg:g")
            .attr("transform", "translate(.5,.5)");

        
          node = root = pathJson;
          
          var nodes = treemap.nodes(root)
              .filter(function(d) { return !d.children; });

          var cell = svg.selectAll("g")
              .data(nodes)
              .enter().append("svg:g")
              .attr("class", "cell")
              .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; })
              .on("click", function(d) { return zoom(node == d.parent ? root : d.parent); });

          cell.append("svg:rect")
              .attr("width", function(d) { return d.dx - 1; })
              .attr("height", function(d) { return d.dy - 1; })
              .style("fill", function(d) { return color(d.parent.name); });

          cell.append("svg:text")
              .attr("x", function(d) { return d.dx / 2; })
              .attr("y", function(d) { return d.dy / 2; })
              .attr("dy", ".35em")
              .attr("text-anchor", "middle")
              .text(function(d) { return d.name; })
              .style("opacity", function(d) { d.w = this.getComputedTextLength(); return d.dx > d.w ? 1 : 0; });

          d3.select(window).on("click", function() { zoom(root); });

          d3.select("select").on("change", function() {
            treemap.value(this.value == "size" ? size : count).nodes(root);
            zoom(node);
          });
        
        
        function size(d) {
          return d.size;
        }

        function count(d) {
          return 1;
        }

        function zoom(d) {
          //alert(d.name);
          var kx = w / d.dx, ky = h / d.dy;
          x.domain([d.x, d.x + d.dx]);
          y.domain([d.y, d.y + d.dy]);

          var t = svg.selectAll("g.cell").transition()
              .duration(d3.event.altKey ? 7500 : 750)
              .attr("transform", function(d) { return "translate(" + x(d.x) + "," + y(d.y) + ")"; });

          t.select("rect")
              .attr("width", function(d) { return kx * d.dx - 1; })
              .attr("height", function(d) { return ky * d.dy - 1; })

          t.select("text")
              .attr("x", function(d) { return kx * d.dx / 2; })
              .attr("y", function(d) { return ky * d.dy / 2; })
              .style("opacity", function(d) { return kx * d.dx > d.w ? 1 : 0; });
              //.style("font-size", function(d) { return kx * d.dx > d.w ? "20px" : "12px";});

          node = d;
          d3.event.stopPropagation();
        }
    </script>
  </body>
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

<div id="chartdiv" style="height:600px;"></div>