<?php
//デバッグ用表示
    // echo 'デバッグ用表示';
    // echo '<pre>';
    // //print_r($tree);
    // echo '</pre>';
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

		<ol class="breadcrumb">
		  <li><?php echo $this->Html->link('Home',array('controller' => 'graphs', 'action' => 'index'));?></li>
		  <li class="active">各開発グループ</a></li>
		  <li class="active">ファイルメトリクス</li>
		</ol>
      <div class="page-header">


	<?php 
	    echo $this->Form->create('Graph',array('inputDefaults' => 
	                                        array('div' => 'form-group',),
	                                        'class' => 'well form-inline',
	                                        )
	                            );
		echo $this->element('selectModel',$groupName); 
	  echo $this->element('selectGroup',$groupName); 
	  echo $this->element('setButton'); 

	  echo $this->Form->input('レイヤー',array
		(
			'id'=>'test',
		    'type'=>'number',
		    'class' => 'form-control',
		    'step'=>1,
		    'min'=>0,
		    'max'=>$depth,
		    'value'=>1,
		    // 'list'=>array(1,2,3),
		 ));	
	?>

	    <select id = "select" class = "form-control">
	    	  <option value="size">Size</option>
	        <option value="count">Count</option>
	    </select>
	<?php 
    echo $this->Form->end();
  ?>
    </div>
	<div id="body"></div>
</body>
<script type="text/javascript">

    function set(layer)
    {
    	$("#body").empty();
    	var pathJson = JSON.parse('<?php echo $tree; ?>');

		var w = 930 - 80,
        h = 800 - 180,
        x = d3.scale.linear().range([0, w]),
        y = d3.scale.linear().range([0, h]),
        color = d3.scale.category20(),
        root,
        node;

        var treemap = d3.layout.treemap()
            .round(false)
            .size([w, h])
            .sticky(true)
            .padding([0, 0, 0, 0])
            .value(function(d) { return document.getElementById("select").options[0].selected ? d.size : 1; });//selectの0番目はsizeなのでそちらが選択されていればsize,そうでなければcountなので1
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
              if(isIn && max<d.size)
              {
                max = d.size;
              }
              return isIn;
            });

          var cell = svg.selectAll("g")
              .data(nodes)
              .enter().append("svg:g")
              .attr("class", "cell")
              .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; })
              //.on("click", function(d) { return zoom(d); });
              .on("click", function(d) { return zoom(node == d.parent ? root : d.parent); });

          cell.append("svg:rect")
              .attr("width", function(d) { return d.dx - 1; })
              .attr("height", function(d) { return d.dy - 1; })
              .style("fill", function(d) { return getColor(d.size)/*color(d.size)*/; });
          cell.append("svg:text")//
              .attr("x", function(d) { return d.dx / 2; })
              .attr("y", function(d) { return d.dy / 2; })
              .attr("dy", ".35em")
              .attr("text-anchor", "middle")
              .text(function(d) { return d.name+"("+d.size+")"; })
              .style("opacity", function(d) { d.w = this.getComputedTextLength(); return d.dx > d.w ? 1 : 0; });

          d3.select(window).on("click", function() { zoom(root); });

          d3.select("#select").on("change", function() 
          {
            treemap.value(this.value == "size" ? size : count).nodes(root);
            zoom(node);
          });

          d3.select("#test").on("change", function() 
          {
            set(this.value)
          });

        
        function size(d) {
          return d.size;
        }

        function count(d) {
          return 1;
        }

        function getColor(size)
        {
          // cb_palette <- c("SS" = "#C869FF","S" = "#6BCDFF","M" = "#71FD5E", "L" = "#FECA61", "LL" = "#FA6565")

          var color = "#FA6565";
          var step = max/5;
          if(size == 0)
          {
            color="#DDDDDD"
          }
          else if(size < step)
          {
            color="#C869FF";
          }
          else if(size < step*2)
          {
            color="#6BCDFF";
          }
          else if(size < step*3)
          {
            color="#71FD5E";
          }
          else if(size < step*4)
          {
            color="#FECA61";
          }
          return  color;
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
    }

    set(1);

</script>