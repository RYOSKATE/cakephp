$(function()
{
    //全開初グループのバルーングラフ作成

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
    // var value2 = getData[0]["defact_num"];
    // var value3 = Number(getData[0]["file_num"]);

    var totalDefact = new Array();
    var defactPerFile = new Array();
    var defactPerLoc = new Array();
    var maxFile=0;
    var maxDefact=0;
    for( var i  = 0; i < getData.length; ++i )
    {
        var temp = getData[i];
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
        value = kloc;
        
        data.push({"group":name ,"y": y,"x": x ,"value": value} );
        totalDefact.push({"group":name ,"v": y} );
        defactPerFile.push({"group":name ,"v": y/x} );
        defactPerLoc.push({"group":name ,"v": (1000*y/kloc).toFixed(3)} );
    }
    totalDefact.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});
    defactPerFile.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});
    defactPerLoc.sort(function(a, b) {return (a.v > b.v) ? -1 : 1;});

    var xy = calc(data,maxFile);
    if(data.length==0)
    {
        xy[0]=0;
        xy[1]=0;
        data.push({"group":"" ,"y": 0,"x": x ,"value": 0} );
    }
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
    for(i=0;i<getData.length;++i)
    {
        var l = totalDefact[i]['group'] +":"+totalDefact[i]['v'];
        var m = defactPerFile[i]['group'] +":"+defactPerFile[i]['v'];
        var r = defactPerLoc[i]['group'] +":"+defactPerLoc[i]['v'];
        tableText.push([i+1,l,m,r]);
    }

    $("#rankTable").empty();
    //var num = Number(document.getElementById("dispNum").value);
    var num = getData.length;
    for(i=1;i<num+1;++i)
    {
        document.all.rankTable.innerHTML = document.all.rankTable.innerHTML
                                        + '<tr>'
                                        + '<td>'+ tableText[i][0] +'</td>'
                                        + '<td>'+ tableText[i][1] +'</td>'
                                        + '<td>'+ tableText[i][2] +'</td>'
                                        + '<td>'+ tableText[i][3] +'</td>'
                                        + '</tr>';
    }
 });