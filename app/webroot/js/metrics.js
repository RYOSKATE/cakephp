var radarChartData;

    function setdata(showParam)
    {
        for( var i  = 0; i < dataset1.length; ++i )
        {
            dataset1[i]=dataset1[i]['ModelLayer'][showParam];
            dataset2[i]=dataset2[i]['ModelLayer'][showParam];
        }
        var radarChartData = {
            labels: [
                     "アプリケーション(APP)", 
                     "アプリケーションフレームワーク(FW)", 
                     "ライブラリ(外部OSS)", 
                     "Android Runtime(SYSTEM)", 
                     "HWライブラリ", 
                     "Kernel",//"Kernel/ドライバ/ブートローダー",
                     "Others"
            ],
            datasets: [
                {
                    label:label1,
                    fillColor: "rgba(255,102,0,0.2)",
                    strokeColor: "rgba(255,102,0,1)",
                    pointColor: "rgba(255,102,0,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(255,102,0,1)",
                    data: dataset1
                },
                {
                    label: label2,
                    fillColor: "rgba(252,210,2,0.2)",
                    strokeColor: "rgba(252,210,2,1)",
                    pointColor: "rgba(252,210,2,1)",
                    pointStrokeColor: "#fff",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(252,210,2,1)",
                    data: dataset2
                }
            ]
        };
        return radarChartData;
    }
    
    radarChartData = setdata('all_file_num');

    window.onload = function(){
        window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {responsive: true});
    }

    // JavaScript
    //  イベントハンドラ
    $('#table td').live('click',function(){
      var $cur_td = $(this)[0]; // (1):セルのHTML表現 [0]をつける点に留意のこと。  
      var $cur_tr = $(this).parent()[0]; // (2):行のHTML表現
      // $cur_tr = $(this).closest('tr')[0]; // このほうが確実
      var $select = $cur_td.cellIndex;
      var $param = 'all_file_num';
      switch($select)
      {
          case 1 : $param = 'all_file_num'; break;
          case 2 : $param = 'defect_file_num'; break;
          case 3 : $param = 'defect_per_file'; break;
          case 4 : $param = 'defect_num'; break;
          default :
      }
      radarChartData = setdata($param);
      window.myRadar = new Chart(document.getElementById("canvas").getContext("2d")).Radar(radarChartData, {responsive: true});
    });