
$(function()
{
  //ファイルメトリクスのツリーマップ・グラフをチャートグラフを作成する機能
    var path;
    var scale = (800.0 - 180.0)/(930.0 - 80.0);
    $('#body').height($('#body').width()*scale);
    function set(layer,zoomNode)
    {
      $("#body").empty();
      var pathJson = originPathJson;

    var w = $('#body').width(),
        h = $('#body').height(),
        x = d3.scale.linear().range([0, w]),
        y = d3.scale.linear().range([0, h]),
        root,node;
        var treemap = d3.layout.treemap()
            .round(false)
            .size([w, h])
            .sticky(true)
            .padding([0, 0, 0, 0])
            .value(function(d) { return document.getElementById("select").options[0].selected ? d.metrics : 1; });//selectの0番目はsizeなのでそちらが選択されていればsize,そうでなければcountなので1
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
          var max=0;
          var nodes = treemap.nodes(root).filter(function(d) {
              var isIn = (d.layer==layer ||(d.layer<layer && !d.children));
              if(isIn && max<d.metrics)
              {
                max = d.metrics;//色分け用にその表示レイヤーでの最大欠陥数を計算する
              }
              return isIn;
            });

          var cell = svg.selectAll("g")
              .data(nodes)
              .enter().append("svg:g")
              .attr("class", "cell")
              .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; })
              .on("click", function(d) { 
                if(node == d.parent)//全体表示中ならば
                {
                  //そのファイル内で拡大
                  //zoom(d);
                  return zoom(d);
                }
                else
                {
                  //ここをズーム維持でレイヤーを深くするようにしたい
                  //つまりdがparentになるようなノードだけにフィルタする
                  return zoom(d.parent);//全体に戻る
                }
              });

          cell.append("svg:rect")
              .attr("width", function(d) { return d.dx - 1; })
              .attr("height", function(d) { return d.dy - 1; })
              .style("fill", function(d) { return getColor(d.metrics); });
          cell.append("svg:text")//
              .attr("x", function(d) { return d.dx / 2; })
              .attr("y", function(d) { return d.dy / 2; })
              .attr("dy", ".35em")
              .attr("text-anchor", "middle")
              .text(function(d) { return d.name+"("+d.metrics+")"; })
              .style("opacity", function(d) { d.w = this.getComputedTextLength(); return d.dx > d.w ? 1 : 0; });

          //ツリーマップ外のクリックで全体表示
          //d3.select(window).on("click", function() { zoom(root); });

          //size/countセレクトボックスの切り替え
          d3.select("#select").on("change", function() 
          {
            treemap.value(this.value == "size" ? metrics : count).nodes(root);
            var n = node;
            zoom(root);
            zoom(n);
          });

          //レイヤースピンボックス
          d3.select("#layer").on("change", function() 
          {
            set(this.value,node);
          });

          //全体を表示ボタン
          d3.select("#zoomreset").on("click", function() 
          {
            zoom(root);
          });

        
        function metrics(d) {return d.metrics;}

        function count(d) {return 1;}

        function getColor(size)
        {
          var color = "#FA6565";//赤
          var step = max/5;
          if(size == 0)
          {
            color="#DDDDDD"//灰色
          }
          else if(size < step)
          {
            color="#C869FF";//紫
          }
          else if(size < step*2)
          {
            color="#6BCDFF";//水色
          }
          else if(size < step*3)
          {
            color="#71FD5E";//緑
          }
          else if(size < step*4)
          {
            color="#FECA61";//黄色
          }
          return  color;
        }

        function makeFilePath(d)
        {
          var path = d.name;
          if(path=="root")
            return "";
          while(d.parent.name!="root")
          {
            d=d.parent;
            path = d.name+"/"+path;
          }
          return path;
        }
        function zoom(d)
        {
          document.getElementById("path").innerHTML="表示パス:root/"+makeFilePath(d);
          //alert('zoomBegin  '+d.name);  
          var kx = w / d.dx, ky = h / d.dy;
          x.domain([d.x, d.x + d.dx]);
          y.domain([d.y, d.y + d.dy]);

          var t = svg.selectAll("g.cell").transition()
              .duration(d3.event.altKey ? 7500 : 750)//ズーム速度
              .attr("transform", function(d) { return "translate(" + x(d.x) + "," + y(d.y) + ")"; });

          t.select("rect")
              .attr("width", function(d) { return kx * d.dx - 1; })
              .attr("height", function(d) { return ky * d.dy - 1; })

          t.select("text")
              .attr("x", function(d) { return kx * d.dx / 2; })
              .attr("y", function(d) { return ky * d.dy / 2; })
              .style("opacity", function(d) { return kx * d.dx > d.w ? 1 : 0; })
              .style("font-size", function(d) { return kx * d.dx > d.w ? "20px" : "12px";});

          node = d;
          d3.event.stopPropagation();
          var radarChartData = setdata(node);
          window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {responsive: true});

          //alert('zoomBegin:  '+node);  
        }

        if(zoomNode)
        {
          zoom(zoomNode);
        }
    }

    set(1);
    //Canvasのサイズをウィンドウサイズに追従
    window.addEventListener( 'resize', onWindowResize, false );
    function onWindowResize(){
       set(1);
    }
  var radarChartData;

  function setdata(node)
  {
    var dataset = [];
    var names = Object.getOwnPropertyNames( node );
    for (var i = 0, len = 25; i < len; ++i) {
      var name = "metrics" + i;
        if(0<=$.inArray(name, names))
        {
          dataset.push(node[name])
        }
    }
    
    labels = [];
    for (var i = 0; i < chartMetricsStr.length; ++i) {
      labels.push(chartMetricsStr[i]);
    }
    var radarChartData = {
        labels: labels,
        datasets: [
            {
                label:"MetricsData",
                fillColor: "rgba(255,102,0,0.2)",
                strokeColor: "rgba(255,102,0,1)",
                pointColor: "rgba(255,102,0,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(255,102,0,1)",
                data: dataset
            }
        ]
    };
    return radarChartData;
  }

  var radarChartData = setdata(originPathJson);
  window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {responsive: true});
});