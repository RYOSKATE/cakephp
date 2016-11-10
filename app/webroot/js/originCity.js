
$(function()
{
		var w = $('#canvas-wrapper').width();
	$('#canvas1').width(w);
	$('#canvas2').width(w);
	$('#canvas1').height(w);
	$('#canvas2').height(w);

	makeRegionGraph(originalSum1, 1,w);
	makeRegionGraph(originalSum2, 2,w);
	function makeRegionGraph(originsum, num,w)
	{
		var sum = originsum;//ここは関数の引数にする

		var allOfZero=true;
		$.each(sum,function(index,val){
			allOfZero &= (val == 0);
		});
		if(allOfZero)
			return;

		//var originSum1 = new Array(0, 8, 2, 2, 153, 183, 27, 334);
		var WIDTH = Math.round(w);
		var HEIGHT = WIDTH;
		
		var WindowSize = new Vec2(WIDTH, HEIGHT);
		var WindowCenter = new Vec2(WIDTH / 2, HEIGHT / 2);

		// 連想配列を生成する
		var o = { 0: 0, 1 : 1, 12 : 2, 2 : 3, 13 : 4, 123 : 5, 23 : 6, 3 : 7 };
		var sum1 = sum[o[1]] + sum[o[12]] + sum[o[13]] + sum[o[123]];
		var sum2 = sum[o[2]] + sum[o[12]] + sum[o[23]] + sum[o[123]];
		var sum3 = sum[o[3]] + sum[o[13]] + sum[o[23]] + sum[o[123]];

		function radiusFromArea(area) {
			return Math.sqrt(area / Math.PI);
		}

		var maxSum = Math.max(sum1, sum2, sum3);
		var maxR = radiusFromArea(maxSum);
		var scale = (HEIGHT / 4.0) / maxR;//直径が画面の縦の半分程度になるようスケール調整
		sum = sum.map(function(value, index, array) { return value*scale*scale; });

		sum1 = sum[o[1]] + sum[o[12]] + sum[o[13]] + sum[o[123]];
		sum2 = sum[o[2]] + sum[o[12]] + sum[o[23]] + sum[o[123]];
		sum3 = sum[o[3]] + sum[o[13]] + sum[o[23]] + sum[o[123]];

		var r1 = radiusFromArea(sum1);
		var r2 = radiusFromArea(sum2);
		var r3 = radiusFromArea(sum3);

		var e1 = new Circle(WIDTH / 2 - r1, HEIGHT / 2, r1);
		var e2 = new Circle(WIDTH / 2 + r2, HEIGHT / 2, r2);
		var e3 = new Circle(WIDTH / 2, HEIGHT / 3, r3);

		var preError = Number.MAX_VALUE;

		function crossArea(a, b)
		{
			var dist = a.distanceFrom(b);
			if (a.r + b.r <= dist)//円aと円bが十分に離れて重なる領域がない場合
			{
				return 0.0;
			}
			else if (dist <= Math.abs(a.r - b.r))//円aが円bの中に完全に内包されている場合
			{
				var r = Math.min(a.r, b.r);
				return r*r*Math.PI;
			}
			else
			{
				//2つの交点が存在する。
				function D(x, y, z)
				{
					return x*x + y*y - z*z;
				}
				var da = D(dist, a.r, b.r);
				var db = D(dist, b.r, a.r);
				return a.r * a.r * Math.acos(da / (2.0 * dist * a.r))
					+ b.r * b.r * Math.acos(db / (2.0 * dist * b.r))
					- Math.sqrt(4 * dist*dist * a.r * a.r - da*da) / 2.0;
			}
		}


		var sum12_123 = sum[o[12]] + sum[o[123]];
		var areae12 = crossArea(e1, e2);
		var err12_123 = (areae12 - sum12_123) / sum12_123;
		var prePosX = e2.x;
		while (Math.abs(err12_123) < preError)
		{
			prePosX = e2.x;
			preError = Math.abs(err12_123);
			var dir = new  Vec2(1, 0);
			if (err12_123 < 0)//重なりが多過ぎたら正、小さければ負になる
			{
				dir.x = -1;
			}
			e2.moveBy(dir.x, dir.y);
			areae12 = crossArea(e1, e2);
			err12_123 = (areae12 - sum12_123) / sum12_123;
		}
		e2.x = prePosX;

		//その由来の現在の面積
		var areas = new Array(0, 0, 0, 0, 0, 0, 0, 0);
		//その画素の由来
		var origin = new Array();
		for (var y = 0; y < HEIGHT; ++y)
		{
			var ow = new Array(WIDTH);
			for (var x = 0; x < WIDTH; ++x)
			{
				var pos = new Vec2(x, y);
				var ei1 = e1.contains(pos);
				var ei2 = e2.contains(pos);
				ow[x] = 0;
				if (ei1)
				{
					if (ei2)
						ow[x] = o[12];
					else
						ow[x] = o[1];
				}
				else if (ei2)
				{
					ow[x] = o[2];
				}
				var ori = ow[x];

				++areas[ori];
			}
			origin.push(ow);
		}

		var rec = new Array(WIDTH*HEIGHT);


		function crossPoint(a, b)
		{
			//まずaを小さい円,bを大きい円にする
			var swaped = b.area() < a.area();
			if (swaped) {
				var t = b; b = a; a = t;
			}
			var d = new Vec2(b.x - a.x, b.y - a.y);
			var lengthSq = d.length()*d.length();
			var dist = Math.sqrt(lengthSq);

			if (a.r + b.r <= dist)
			{
				//円aと円bが十分に離れて重なる領域がない場合
				if (swaped) {
					var t = b; b = a; a = t;
				}
				return new Vec2(-1, -1);
			}
			else if (a.r + dist <= b.r)
			{
				//円aが円bの中に完全に内包されている場合
				if (swaped) {
					var t = b; b = a; a = t;
				}
				return new Vec2(0, 0);
			}
			//2つの交点が存在する。
			var cos1 = d.x / dist;
			var sin1 = d.y / dist;
			var x1 = (a.r*a.r - b.r*b.r + lengthSq) / (2.0 * dist);
			var y1 = Math.sqrt(a.r*a.r - x1*x1);

			var yp1 = x1*sin1 + y1*cos1 + a.y;
			var yp2 = x1*sin1 - y1*cos1 + a.y;
			if (yp1<yp2)
			{
				return new Vec2(x1*cos1 - y1*sin1 + a.x, yp1);
			}
			else
			{
				return new Vec2(x1*cos1 + y1*sin1 + a.x, yp2);
			}
		}

		var range = 2;//この値を大きくすれば丸くなる。

		var serchPoints = new Array();
		for (var y = -range; y <= range; ++y)
		{
			for (var x = -range; x <= range; ++x)
			{
				var pos = new Vec2(x, y);
				//var serchRangeCircle = new Circle(0,0,range);
				if (new Circle(0, 0, range).contains(pos))
					serchPoints.push(pos);
			}
		}

		//ここを有効化すると処理は重くなるが放射状に領域拡張していく
		// serchPoints.sort(function(va, vb)
		// {
		// 	var a = va.length();
		// 	var b = vb.length();
		// 	if (a < b)
		// 		return -1;
		// 	if (a > b)
		// 		return 1;
		// 	return 0;
		// });
		// serchPoints.shift();


		var queue = new Queue();//Vec2を格納する
		var point12 = crossPoint(e1, e2);
		if (point12.x != -1 && point12.y != -1)
		{
			point12.x = Math.round(point12.x);
			point12.y = Math.round(point12.y);
		}
		else
		{
			point12.x = Math.round((e1.x + e2.x) / 2);
			point12.y = Math.round((e1.y + e2.y) / 2);
		}
		queue.push(point12);
		while (!queue.empty())
		{
			function pushArounds(p)
			{
				function isIn(pp)
				{
					return 0 <= pp.x && pp.x < WIDTH && 0 <= pp.y && pp.y < HEIGHT;
				};
				for (var i = 0; i<serchPoints.length; ++i)
				{
					var newPos = p.movedBy(serchPoints[i].x, serchPoints[i].y);
					if (isIn(newPos))
					{
						queue.push(newPos);
					}
				}
			};
			//候補座標をpopする
			var from = queue.pop();
			var ori = origin[from.y][from.x];//その座標の現在の由来
			if (ori == o[1] || ori == o[12] || ori == o[2])
			{
				//o1,o2,o12はareaが最初からsum[1],sum[12],sum[2]より多いはず
				var newOrigin = ori + 3;
				if (sum[ori] < areas[ori] && areas[newOrigin]<sum[newOrigin])
				{
					--areas[ori];
					++areas[newOrigin];
					origin[from.y][from.x] = newOrigin;
					pushArounds(from);
				}
			}
			//o3,o13,o23,o123のareaは0スタートでsumまで増やす
			else if (ori == 0)
			{
				//なにもないところならo3にする
				if (areas[o[3]]<sum[o[3]])
				{
					--areas[0];
					++areas[o[3]];
					origin[from.y][from.x] = o[3];
					pushArounds(from);
				}
			}
		}
		
		var originColor = {
			0: 	'#FFFFFF',//不使用
			1 : '#FA6565',//赤
			2 : '#FECA61',//黄
			3 : '#71FD5E',//緑
			4 : '#7869FF',//紫
			5 : '#DDDDDD',//灰
			6 : '#6BCDFF',//水
			7 : '#0055FF'//青
		};
		var canvas;
		if(num==1)
			canvas= new fabric.Canvas('canvas1');
		else 
			canvas= new fabric.Canvas('canvas2');
		canvas.setWidth(w);
		canvas.setHeight(w);
		//o1全体の円とo2全体の円は最初に描画しておく
		var circle1 = new fabric.Circle({
		originX: 'center',
				originY : 'center',
			left : e1.x,//x
			top : e1.y,//y
			fill : originColor[o[1]],
			radius : r1,
			selectable : false,
			//opacity : 0.5
		});
		canvas.add(circle1);
		var circle2 = new fabric.Circle({
			originX: 'center',
			originY : 'center',
			left : e2.x,//x
			top : e2.y,//y
			fill : originColor[o[2]],
			radius : r2,
			selectable : false,
			//opacity : 0.5
		});
		canvas.add(circle2);

		//それぞれの領域の画素を結合したポリゴンを作成する
		var drawPoints = new Array();
		var minPos = new Array();
		for (var i = 0; i<8; ++i)
		{
			minPos.push(new Vec2(WIDTH, HEIGHT));
			drawPoints.push(new Array());
		}
		
		function isSurrounded(x,y)
		{
			var ori = origin[y][x];
			var touched = 0;
			for(var w= -1; w<=1;++w)
			{
				for(var h= -1; h<=1;++h)
				{
					if(0 <= x+w && x+w < WIDTH && 0 <= y+h && y+h < HEIGHT)
					{
						if(ori == origin[y+h][x+w])
						{
							++touched;
						}
					}
				}
			}
			return touched==9;
		}
		for (var h = 0; h < HEIGHT; ++h)
		{
			for (var w = 0; w < WIDTH; ++w)
			{
				var ori = origin[h][w];
				if (ori != 0)
				{				
					if(!isSurrounded(w,h))
					{
						if (w<minPos[ori].x)
							minPos[ori].x = w;
						if (h<minPos[ori].y)
							minPos[ori].y = h;
						drawPoints[ori].push({ x: w, y : h })
					}
				}
			}
		}
		var paintedRegion = [o[3], o[12], o[13], o[23], o[123]];
		for (var n = 0; n<paintedRegion.length; ++n)
		{
			var i = paintedRegion[n];
			var polygon = new fabric.Polygon(drawPoints[i], {
				top: minPos[i].y,
				left : minPos[i].x,
				fill : originColor[i],
				stroke : originColor[i],
				strokeWIDTH : 1,
				selectable : false,
				//opacity : 0.9
			});

			canvas.add(polygon);
		}
		canvas.on('mouse:down', function(options) 
		{
  			if (options.target) 
			{
    			console.log('an object was clicked! ', options.target.type);
  			}
		});
		
		
        //Canvasのサイズをウィンドウサイズに追従
        window.addEventListener( 'resize', onWindowResize, false );

        function onWindowResize(){
			var w = $('#canvas-wrapper').width();
			$('#canvas1').width(w);
			$('#canvas2').width(w);
			$('#canvas1').height(w);
			$('#canvas2').height(w);
			canvas.setWidth(w);
			canvas.setHeight(w);
			canvas.calcOffset();
        }
	}


//以下はクラス(みたいなもの)
	function Vec2(x, y)
	{
		//コンストラクタとメンバ変数
		this.x = x;
		this.y = y;
		////// メンバ関数
		this.moveBy = moveBy;
		this.movedBy = movedBy;
		this.length = length;
		this.distanceFrom = distanceFrom;
		this.normalized = normalized;
		function moveBy(d_x, d_y) {
			this.x += d_x;
			this.y += d_y;
			return this;
		}
		function movedBy(d_x, d_y) {
			var t = new Vec2(this.x, this.y);
			return t.moveBy(d_x, d_y);
		}
		function length(other) {
			return Math.sqrt(this.x*this.x + this.y*this.y);
		}
		function distanceFrom(other) {
			var d_x = this.x - other.x;
			var d_y = this.y - other.y;
			return Math.sqrt(d_x*d_x + d_y*d_y);
		}
		function normalized() {
			var l = this.length();
			var t = new Vec2(this.x / l, this.y / l);
			return t;
		}
	}
	function Circle(x, y, r)
	{
		//コンストラクタとメンバ変数
		this.x = x;
		this.y = y;
		this.r = r;
		this.contains = contains;
		this.moveBy = moveBy;
		this.movedBy = movedBy;
		this.distanceFrom = distanceFrom;
		this.area = area;
		////// メンバ関数
		function contains(v2) {
			var dist = this.distanceFrom(v2);
			return dist < this.r;
		}
		function moveBy(d_x, d_y) {
			this.x += d_x;
			this.y += d_y;
			return this;
		}
		function movedBy(d_x, d_y) {
			var t = new Vec2(this.x, this.y);
			return t.moveBy(d_x, d_y);
		}

		function distanceFrom(other) {
			var d_x = this.x - other.x;
			var d_y = this.y - other.y;
			return Math.sqrt(d_x * d_x + d_y * d_y);
		}
		function area() {
			return Math.PI*this.r*this.r;
		}
	}

	function Queue()
	{
		this.__a = new Array();
		this.push = push;
		this.pop = pop;
		this.size = size;
		this.empty = empty;
		this.toString = toString;
		function push(o)
		{
			this.__a.push(o);
		}
		function size()
		{
			return this.__a.length;
		}
		function empty()
		{
			return 0 == this.size()
		}
		function pop()
		{
			if (!this.empty())
			{
				return this.__a.shift();
			}
			return null;
		}
		function toString()
		{
			return '[' + this.__a.join(',') + ']';
		}
	}
});