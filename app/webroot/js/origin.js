
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
function toggleActive()
{
    $('#o123').toggleClass('active');
    $('#o23').toggleClass('active');
    $('#o3').toggleClass('active');

}
AmCharts.ready(function () 
{
    toggleActive();
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
    toggleActive();
});