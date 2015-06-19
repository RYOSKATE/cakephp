<?php $this->Html->script('amcharts/xy', array('inline' => false));?>

<script type="text/javascript">

    var testAData = JSON.parse('<?=json_encode($data);?>');
    /*
      $data[] = array('model'=>$modelname,
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

    var totalDefact = new Array();
    var defactPerFile = new Array();
    var defactPerLoc = new Array();
    for( var i  = 0; i < testAData.length; ++i )
    {
        var temp = testAData[i]['GroupData'];
        var y = Number(temp['defact_num']);
        var x = Number(temp['file_num']);
        var kloc = Number(temp['loc']);
        var name = temp['group_name'];
        var dist = Math.abs(y-x)/Math.sqrt(2);
        var value = parseInt(Math.round(dist));
        testArray.push({"group":name ,"y": y,"x": x ,"value": value} );
        totalDefact.push({"group":name ,"v": y} );
        defactPerFile.push({"group":name ,"v": y/x} );
        defactPerLoc.push({"group":name ,"v": (1000*y/kloc).toFixed(3)} );
    }
    testArray.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});
    defactPerFile.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});
    defactPerLoc.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});

	AmCharts.themes.none = {}; 

	var chart = AmCharts.makeChart("chartdiv", {
    "type": "xy",
    "pathToImages": "http://www.amcharts.com/lib/3/images/",
    "theme": "none",
    "dataProvider":testArray,
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
<?php 
    echo $this->Form->create('Graph',array('inputDefaults' => 
                                        array('div' => 'form-group',),
                                        'class' => 'well form-inline')
                                        );
    echo $this->element('selectModel',$modelName);
    echo $this->element('selectGroup',$groupName); 
    echo $this->Form->end('セット', array
    (
    'class' => 'form-control'
    ));
?>
</div>

<div id="chartdiv" style="height:500px;"></div>

<div id ="table"></div>
<script type="text/javascript">
    // 表をつくる関数
    function makeTable(totalDefact,defactPerFile,defactPerLoc,divname)
    {
        var tableText=[["順位","合計欠陥数","ファイルあたりの欠陥数","欠陥密度(LOC)"]];
        // 表に表示するテキストデータをまとめる
        for(i=0;i<10;i++)
        {
            var l = totalDefact[i]['group'] +":"+totalDefact[i]['v'];
            var m = defactPerFile[i]['group'] +":"+defactPerFile[i]['v'];
            var r = defactPerLoc[i]['group'] +":"+defactPerLoc[i]['v'];
            tableText.push([i+1,l,m,r]);
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
    makeTable(totalDefact,defactPerFile,defactPerLoc,"table");
</script>