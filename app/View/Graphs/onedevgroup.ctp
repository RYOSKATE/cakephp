<?php $this->Html->script('amcharts/serial', array('inline' => false));?>
<?php $this->Html->script('amcharts/amstock', array('inline' => false));?>

<?php
//デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // print_r($model);
    // echo '</pre>';
?>
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


		// second stock panel
		//棒グラフ株のストックグラフ(描画対象データがないため非表示)
		/*
		var stockPanel2 = new AmCharts.StockPanel();
		stockPanel2.title = "Volume";
		stockPanel2.percentHeight = 30;
		var graph2 = new AmCharts.StockGraph();
		graph2.valueField = "volume";
		graph2.type = "column";
		graph2.showBalloon = false;
		graph2.fillAlphas = 1;
		stockPanel2.addStockGraph(graph2);

		var stockLegend2 = new AmCharts.StockLegend();
		stockLegend2.periodValueTextRegular = "[[value.close]]";
		stockPanel2.stockLegend = stockLegend2;

		
		chart.panels = [stockPanel1, stockPanel2];
		*/

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
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                        array('div' => 'form-group',),
                                        'class' => 'well form-inline',
                                        )
                            );
    for($i=1;$i<=4;++$i)
    {
    	echo $this->Form->input('モデル'.$i,array
		(
		    'type'=>'select',
		    'options'=>$modelName,
		    'class' => 'form-control'
		 ));
    }
    echo $this->element('selectGroup',$groupName); 
    echo $this->Form->end('セット', array
    (
    'class' => 'form-control'
    ));


?>
</div>

<div id="chartdiv" style="height:600px;"></div>
