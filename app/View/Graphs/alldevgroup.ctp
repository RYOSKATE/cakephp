<?php $this->Html->script('amcharts/xy', array('inline' => false));?>

<script type="text/javascript">

    //最小二乗法による傾きと切片を求める
    function calc(data,maxFile)
    {
        var N = data.length;
        
        var sum_xy = 0, sum_x = 0, sum_y = 0, sum_xx = 0;

        for (i=0; i<N; i++) 
        {
            var x = data[i]['x'];
            var y = data[i]['y'];
            sum_xy += x * y;
            sum_x += x;
            sum_y += y;
            sum_xx += x*x
        }
      
        var a = (N * sum_xy - sum_x * sum_y) / (N * sum_xx - sum_x*sum_x);
        var b = (sum_xx * sum_y - sum_xy * sum_x) / (N * sum_xx - sum_x*sum_x);

        var d = [b,a*maxFile+b];
        return d;
    }
    var getData = JSON.parse('<?=json_encode($data);?>');
    /*
      $data[] = array('model'=>$modelname,
                'group_name' =>$key,
                'file_num'   =>$value['file_num'],
                'defact_num' =>$value['defact_num'],
                'loc'        =>$value['loc'],
                'date'       =>$time);
    */
    var data = new Array();
    // var value1 = getData[0];
    // var value2 = getData[0]["GroupData"]["defact_num"];
    // var value3 = Number(getData[0]['GroupData']["file_num"]);

    var totalDefact = new Array();
    var defactPerFile = new Array();
    var defactPerLoc = new Array();
    var maxFile=0;
    var maxDefact=0;
    for( var i  = 0; i < getData.length; ++i )
    {
        var temp = getData[i]['GroupData'];
        var y = Number(temp['defact_num']);
        var x = Number(temp['file_num']);
        var kloc = Number(temp['loc']);
        var name = temp['group_name'];

        if(maxFile<x)
        {
            maxFile=x;
        }
        if(maxDefact<y)
        {
            maxDefact=y;
        }
        //バブルサイズの計算式
        //var dist = (y-x)/Math.sqrt(2);
        //var value = parseInt(Math.round(dist));
        value = y;
        
        data.push({"group":name ,"y": y,"x": x ,"value": value} );
        totalDefact.push({"group":name ,"v": y} );
        defactPerFile.push({"group":name ,"v": y/x} );
        defactPerLoc.push({"group":name ,"v": (1000*y/kloc).toFixed(3)} );
    }
    data.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});
    defactPerFile.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});
    defactPerLoc.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});

    var xy = calc(data,maxFile);
	AmCharts.themes.none = {}; 

	var chart = AmCharts.makeChart("chartdiv", {
    "type": "xy",
    "pathToImages": "http://www.amcharts.com/lib/3/images/",
    "theme": "none",
    "dataProvider":data,
    "valueAxes": [{
        "axisAlpha": 0,
        "position":"bottom",
        "title": "ファイル数"
    }, {
        "axisAlpha": 0,
        "position": "left",
        "title": "欠陥数"
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
    }],
    "trendLines": [{
        "finalValue": xy[1],
        "finalXValue": maxFile,
        "initialValue": xy[0],
        "initialXValue": 0,
        "lineColor": "#FF6600"
    }],
    "chartScrollbar": {},
    "chartCursor": {},
    });



    var tableText=[["順位","合計欠陥数","ファイルあたりの欠陥数","欠陥密度(LOC)"]];
    // 表に表示するテキストデータをまとめる
    for(i=0;i<10;++i)
    {
        var l = totalDefact[i]['group'] +":"+totalDefact[i]['v'];
        var m = defactPerFile[i]['group'] +":"+defactPerFile[i]['v'];
        var r = defactPerLoc[i]['group'] +":"+defactPerLoc[i]['v'];
        tableText.push([i+1,l,m,r]);
    }
</script>

<ol class="breadcrumb">
  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
  <li class="active">全開発グループ</a></li>
  <li class="active">欠陥数散布図</li>
</ol>

<div class="page-header">
<?php 
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                        array('div' => 'form-group',),
                                        'class' => 'well form-inline')
                                        );
    echo $this->element('selectModel',$modelName);
    echo $this->element('selectGroup',$groupName); 
    echo $this->element('setButton'); 
    echo $this->Form->end();
?>
</div>

<div id="chartdiv" style="height:500px;"></div>

<div class="row">
    <div class="col-md-12 col-sm-12" >
    <table class="table table-hover table-condensed" id ="table">
        <thead>
        <tr>
            <th>順位</th>
            <th>合計欠陥数</th>
            <th>ファイルあたりの欠陥数</th>
            <th>欠陥密度(LOC)</th>
        </tr>
        </thead>
        <tbody>
<script>
    for(i=1;i<11;++i)
    {
        document.write("<tr>");
        for(j=0;j<4;++j)
        {
            document.write("<td>"+tableText[i][j]+"</td>");
        }
        document.write("</tr>");
    }
</script>
        </tbody>
    </table>
    </div>
</div>