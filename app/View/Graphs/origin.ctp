
<?php
//デバッグ用表示
    echo 'デバッグ用表示';
    echo '<pre>';
    //print_r($model1);
    //print_r($model2);
    echo '</pre>';
?>
<?php $this->Html->script('amcharts/pie', array('inline' => false));?>

<script>
    $(function () {
    $('#myTab a:first').tab('show')
    })

    $('#myTab a').click(
        function (e) 
        { 
            e.preventDefault()
            $(this).tab('show')
        }
    )
</script>
<!-- Pie leftChart[origin] with leftlegend[origin]-->
<script type="text/javascript">

    var defactsByOrigin1 = JSON.parse('<?=json_encode($model1);?>');

    var chartData1 = [];
    for (var origin = 0; origin < defactsByOrigin1.length; ++origin) 
    {
        var defacts = defactsByOrigin1[origin];
        var chartDataByOrigin = [];
        for (var j = 0; j < defacts.length; ++j) 
        {
            if(defacts[j]!=0)
            {
                chartDataByOrigin.push({ "numOfDefacts": String(j), "numOfFiles": defacts[j] });
            }
        }
        chartData1.push(chartDataByOrigin);
    }

    var defactsByOrigin2 = JSON.parse('<?=json_encode($model2);?>');

    var chartData2 = [];
    for (var origin = 0; origin < defactsByOrigin1.length; ++origin) 
    {
        var defacts = defactsByOrigin2[origin];
        var chartDataByOrigin = [];
        for (var j = 0; j < defacts.length; ++j) 
        {
            if(defacts[j]!=0)
            {
                chartDataByOrigin.push({ "numOfDefacts": String(j), "numOfFiles": defacts[j] });
            }
        }
        chartData2.push(chartDataByOrigin);
    }

    var leftChart = [];
    var rightChart = [];
    var leftlegend = [];
    var rightlegend = [];

/*
origin(実際の由来は+1する)
0:0が71831 99.9%
1:0が928 100%
2:0が5835 100%
3:0-10で0が624の3/4くらい
4:0-18 0が半分ちょい
5:0-2 0が半分ちょい
6:0-39 0が8割くらい
*/
    // 由来(1-7 = o2,o12,o1,o13,o123,o23,o3)0は使ってないらしい
    AmCharts.ready(function () 
    {
        for (var origin = 4; origin <chartData1.length; ++origin) 
        {   
            // PIE CHART
            leftChart[origin] = new AmCharts.AmPieChart();
            leftChart[origin].dataProvider = chartData1[origin];
            leftChart[origin].titleField = "numOfDefacts";
            leftChart[origin].valueField = "numOfFiles";

            // LEGEND
            leftlegend[origin] = new AmCharts.AmLegend();
            leftlegend[origin].align = "center";
            leftlegend[origin].markerType = "circle";
            leftChart[origin].balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
            leftChart[origin].addLegend(leftlegend[origin]);

            // WRITE
            leftChart[origin].write("leftChart"+origin);

            // PIE CHART
            rightChart[origin] = new AmCharts.AmPieChart();
            rightChart[origin].dataProvider = chartData2[origin];
            rightChart[origin].titleField = "numOfDefacts";
            rightChart[origin].valueField = "numOfFiles";

            // LEGEND
            rightlegend[origin] = new AmCharts.AmLegend();
            rightlegend[origin].align = "center";
            rightlegend[origin].markerType = "circle";
            rightChart[origin].balloonText = "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>";
            rightChart[origin].addLegend(rightlegend[origin]);

            // WRITE

            rightChart[origin].write("rightChart"+origin);

            // changes label position (labelRadius)
            leftChart[origin].labelRadius = -30;
            leftChart[origin].labelText = "[[percents]]%";
            rightChart[origin].labelRadius = -30;
            rightChart[origin].labelText = "[[percents]]%";
            leftChart[origin].validateNow();
            rightChart[origin].validateNow();
            // makes leftChart[origin] 2D/3D                   
            leftChart[origin].depth3D = 0;
            leftChart[origin].angle = 0;
            rightChart[origin].depth3D = 0;
            rightChart[origin].angle = 0;	
            leftChart[origin].validateNow();
            rightChart[origin].validateNow();
            // changes switch of the leftlegend[origin] (x or v)
            leftlegend[origin].switchType = "x";
            rightlegend[origin].switchType = "x";
            leftlegend[origin].validateNow();
            rightlegend[origin].validateNow();
        }
    });

</script>
<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
  <li class="active">モデル</a></li>
  <li class="active">由来比較</li>
</ol>

<div class="page-header">
  <h1><small>由来比較</small></h1>
</div>
<!-- Nav tabs -->
<!-- // 由来(1-7 = o2,o12,o1,o13,o123,o23,o3)0は使ってないらしい -->
<ul class="nav nav-tabs" id = "mytab" role="tablist">
  <li><a href ="#o13" role="tab" data-toggle="tab">o13</a></li>         
  <li><a href ="#o123"role="tab" data-toggle="tab">o123</a></li>        
  <li><a href ="#o23" role="tab" data-toggle="tab">o23</a></li>         
  <li><a href ="#o3"  role="tab" data-toggle="tab">o3</a></li>         
</ul>
<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane fade in active" id="o13">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">XXXモデル</div>
                </div>
                <div class="panel-body">
                    <div id="leftChart4" style="height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">YYYモデル</div>
                </div>
                <div class="panel-body">
                    <div id="rightChart4" style="height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade in active" id="o123">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">XXXモデル</div>
                </div>
                <div class="panel-body">
                    <div id="leftChart5" style="height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">YYYモデル</div>
                </div>
                <div class="panel-body">
                    <div id="rightChart5" style="height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade in active" id="o23">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">XXXモデル</div>
                </div>
                <div class="panel-body">
                    <div id="leftChart6" style="height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">YYYモデル</div>
                </div>
                <div class="panel-body">
                    <div id="rightChart6" style="height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
  </div>
  <div class="tab-pane fade in active" id="o3">
    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">XXXモデル</div>
                </div>
                <div class="panel-body">
                    <div id="leftChart7" style="height:500px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">YYYモデル</div>
                </div>
                <div class="panel-body">
                    <div id="rightChart7" style="height:500px;"></div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
