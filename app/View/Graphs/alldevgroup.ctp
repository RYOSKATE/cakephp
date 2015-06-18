<?php $this->Html->script('amcharts/xy', array('inline' => false));?>
<?php
//デバッグ用表示
    echo 'デバッグ用表示';
    echo '<pre>';
        print_r($testA[0]);
    echo '</pre>';
?>
<script type="text/javascript">

    var testAData = JSON.parse('<?=json_encode($testA);?>');
    /*
    $data[]      = array('model'=>$modelname,
                'group_name' =>$key,
                'file_num'   =>$value['file_num'],
                'defact_num' =>$value['defact_num'],
                'loc'        =>$value['loc'],
                'date'       =>$time);
    */
    var testArray = new Array();
    var value1 = testAData[0];
    var value2 = testAData[0]["GroupData"]["defact_num"];
    var value3 = Number(testAData[0]['GroupData']["file_num"]);
    var value = 183;

    for( var i  = 0; i < testAData.length; ++i )
    {
        var temp = testAData[i]['GroupData'];
        var y = Number(temp['defact_num']);
        var x = Number(temp['file_num']);
        var name = temp['group_name'];
        var dist = Math.abs(y-x)/Math.sqrt(2);
        var value = parseInt(Math.round(dist));
        testArray.push({"group":name ,"y": y,"x": x ,"value": value,/*,"y2": -5,"x2": -3,"value2": 44*/} );
    }

	AmCharts.themes.none = {}; 

	var chart = AmCharts.makeChart("chartdiv", {
    "type": "xy",
    "pathToImages": "http://www.amcharts.com/lib/3/images/",
    "theme": "none",
    "dataProvider":testArray,
    /*"dataProvider": [{
        "y": 10,
        "x": 14,
        "value": 59,
        "y2": -5,
        "x2": -3,
        "value2": 44
    }, {
        "y": 5,
        "x": 3,
        "value": 50,
        "y2": -15,
        "x2": -8,
        "value2": 12
    }],*/
    "valueAxes": [{
        "position":"bottom",
        "axisAlpha": 0
    }, {
        "minMaxMultiplier": 1.2,
        "axisAlpha": 0,
        "position": "left"
    }],
    "startDuration": 1.5,
    "graphs": [{
        "balloonText": "group:<b>[[group]]</b> <br> x:<b>[[x]]</b> y:<b>[[y]]</b><br>value:<b>[[value]]</b>",
        "bullet": "circle",
        "bulletBorderAlpha": 0.2,
		"bulletAlpha": 0.8,
        "lineAlpha": 0,
        "fillAlphas": 0,
        "valueField": "value",
        "xField": "x",
        "yField": "y",
        "maxBulletSize": 100
    }, {
        "balloonText": "x:<b>[[x]]</b> y:<b>[[y]]</b><br>value:<b>[[value]]</b>",
        "bullet": "diamond",
        "bulletBorderAlpha": 0.2,
		"bulletAlpha": 0.8,
        "lineAlpha": 0,
        "fillAlphas": 0,
        "valueField": "value2",
        "xField": "x2",
        "yField": "y2",
        "maxBulletSize": 100
    }],
    "marginLeft": 46,
    "marginBottom": 35
});
</script>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
  <li class="active">開発グループ</a></li>
  <li class="active">ALL</li>
</ol>

<div class="page-header">
<?php echo $this->element('selectModel',$modelName); ?>
<?php echo $this->element('selectGroup',$groupName); ?>
</div>

<div id="chartdiv" style="height:500px;"></div>
