$(function()
{   
    function calcBuildingPos(data)
    {
        //(2) �R��(1-7 = 2,12,1,13,123,23,3)
        var o = { 2: 0 , 12: 1 ,1: 2 , 13: 3 ,123: 4 , 23: 5 ,3: 6  };
        var boxes = new Array();
        var numOfBuilding = Object.keys(data).length;
        
        for(var i=1;i<=numOfBuilding;++i)
        {
            var box = new Array();
            var numOfLayer = Object.keys(data[i].layerHeight).length;
            var w = 0;
            var h = 0;
            if(i==o[1] || i==o[2] || i==o[3])
            {
                w = Math.sqrt(data[i].originHeight);
                h = w;
            }
            else if(i==o[1] || i==o[2] || i==o[3])
            {
                
                
            }
            for(var j = 0;j<numOfLayer;++j)
            {
                box[j] = new building(0,0,0,v,v,0);
            }
            boxes[i] =box;
        }
	// Array<RectF> originRects(8);

	// auto& t = originNumMap;
	// originRects[t[1]].w = sqrt(count[t[1]]);
	// originRects[t[1]].h = sqrt(count[t[1]]);
	// originRects[t[2]].w = sqrt(count[t[2]]);
	// originRects[t[2]].h = sqrt(count[t[2]]);
	// originRects[t[3]].w = sqrt(count[t[3]]);
	// originRects[t[3]].h = sqrt(count[t[3]]);
	// double o123wh = sqrt(count[t[123]]);

	// originRects[t[123]].w = o123wh;
	// originRects[t[123]].h = o123wh;

	// originRects[t[12]].h = o123wh;
	// originRects[t[23]].w = o123wh;
	// originRects[t[13]].w = o123wh;

	// for (auto & r : originRects)
	// {
	// 	if (r.h < 1)
	// 		r.h = 1;
	// 	if (r.w < 1)
	// 		r.w = 1;
	// }

	// originRects[t[12]].w = count[t[12]] / originRects[t[12]].h;
	// originRects[t[23]].h = count[t[23]] / originRects[t[23]].w;
	// originRects[t[13]].h = count[t[13]] / originRects[t[13]].w;
	// for (auto & r : originRects)
	// {
	// 	if (r.h < 1)
	// 		r.h = 1;
	// 	if (r.w < 1)
	// 		r.w = 1;
	// }
	// constexpr int offset = 20;
	// originRects[t[123]].pos = Vec2::Zero;
	// originRects[t[2]].pos = originRects[t[123]].pos.movedBy(-originRects[t[2]].size).movedBy(-offset,-offset);
	// originRects[t[12]].pos = originRects[t[123]].pos.movedBy(-originRects[t[12]].w, 0).movedBy(-offset, 0);
	// originRects[t[13]].pos = originRects[t[123]].pos.movedBy(0, o123wh).movedBy(0, offset);
	// originRects[t[23]].pos = originRects[t[123]].pos.movedBy(0, -originRects[t[23]].h).movedBy(0, -offset);
	// originRects[t[1]].pos = originRects[t[13]].pos.movedBy(-originRects[t[1]].w, 0).movedBy(-offset, 0);
	// originRects[t[3]].pos = originRects[t[123]].pos.movedBy(o123wh, -Abs(o123wh - originRects[t[3]].h) / 2).movedBy(offset, -offset);

	// return originRects;
       
    }
    function drawBuilding(data)
    {
        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(75, 600 / 400, 1, 1000);
    
        camera.position.set(-100, 50, 100);
    
        renderer = new THREE.WebGLRenderer();
        //var width = document.getElementById('canvas-wrapper').clientWidth;
        //var height =  document.getElementById('canvas-wrapper').clientHeight;
        //renderer.setSize(width, height);

        renderer.setSize(655, 437);
        document.getElementById('canvas-wrapper').appendChild(renderer.domElement);
        
        //x,y,z軸表示
        var  axis = new THREE.AxisHelper(1000);          
        axis.position.set(0,0,1);        
        scene.add(axis);                              
        
        var lightPos = [
            [-100, 50, 100]
        ];
        
        for (var i = 0; i < lightPos.length; i++) {
            var directionalLight = new THREE.DirectionalLight('#FFFFFF', 1);
            directionalLight.position.set(lightPos[i][0],  lightPos[i][1], lightPos[i][2]);
            scene.add(directionalLight);
        }
        
        scene.add(new THREE.AmbientLight(0x333333));  
        //var geometry = new THREE.BoxGeometry(15, 15, 15);
        //var material = new THREE.MeshPhongMaterial({color: 'white'});
    
        var cube = [];
        var colors = [
            '#111111',//黒
            '#C869FF',//紫
            '#6BCDFF',//水色
            '#71FD5E',//緑
            '#FECA61',//黄色
            '#FA6565',//赤
            '#DDDDDD',//灰色
        ];
        var geometries = [
                //画面上方向に+y
                //画面右方向に+x
                //手前方向に+z
                //L
                [100, 3, 100],
                [100, 12, 100],
                [100, 5, 100],
                [100, 2, 100],
                [100, 5, 100],
                [100, 7, 100],
                [100, 3, 100],
                
                [15, 6, 15],
                [15, 6, 15],
                [15, 6, 15],
                [15, 6, 15],
                [15, 6, 15],
                [15, 6, 15],
                [15, 6, 15],
                
                [50, 1, 50],
                [50, 1, 50],
                [50, 1, 50],
                [50, 1, 50],
                [50, 1, 50],
                [50, 1, 50],
                [50, 1, 50],
                
                [15, 9, 15],
                [15, 9, 15],
                [15, 9, 15],
                [15, 9, 15],
                [15, 9, 15],
                [15, 9, 15],
                [15, 9, 15],
                
                [15, 1, 15],
                [15, 2, 15],
                [15, 3, 15],
                [15, 4, 15],
                [15, 5, 15],
                [15, 6, 15],
                [15, 1, 15],

                [15, 6, 15],
                [15, 5, 15],
                [15, 3, 15],
                [15, 1, 15],
                [15, 4, 15],
                [15, 2, 15],
                [15, 1, 15],
                
                [15, 1, 15],
                [15, 1, 15],
                [15, 2, 15],
                [15, 3, 15],
                [15, 5, 15],
                [15, 8, 15],
                [15, 13, 15],
                
                [15, 0, 15],
                [15, 1, 15],
                [15, 1, 15],
                [15, 1, 15],
                [15, 3, 15],
                [15, 20, 15],
                [15, 15, 15],     
        ];
        var position = [
                
                //画面上方向に+y
                //画面右方向に+x
                //手前方向に+z
                //L
                [-50,0,-50],
                [-50,15,-50],
                [-50,30,-50],
                [-50,45,-50],
                [-50,60,-50],
                [-50,75,-50],
                [-50,90,-50],
                
                [-15,0,15],
                [-15,15,15],
                [-15,30,15],
                [-15,45,15],
                [-15,60,15],
                [-15,75,15],
                [-15,90,15],
                
                [-35,0,45],
                [-35,50,45],
                [-35,45,45],
                [-35,45,45],
                [-35,60,45],
                [-35,75,45],
                [-35,90,45],
                
                [0,0,0],
                [0,15,0],
                [0,30,0],
                [0,45,0],
                [0,60,0],
                [0,75,0],
                [0,90,0],

                [0,0,15],
                [0,15,15],
                [0,30,15],
                [0,45,15],
                [0,60,15],
                [0,75,15],
                [0,90,15],

                [0,0,30],
                [0,15,30],
                [0,30,30],
                [0,45,30],
                [0,60,30],
                [0,75,30],
                [0,90,30],

                [15,0,15],
                [15,15,15],
                [15,30,15],
                [15,45,15],
                [15,60,15],
                [15,75,15],
                [15,90,15],
            ];
    
        for (var i = 0; i < position.length; i++) {
            var material = new THREE.MeshPhongMaterial({color: colors[i%7]});
            var geometry = new THREE.BoxGeometry(geometries[i][0],geometries[i][1],geometries[i][2]);
            cube[i] = new THREE.Mesh(geometry, material);
            if(i%7==0)
            {
                cube[i].position.set(position[i][0],0,position[i][2]);
            }
            else
            {
                cube[i].position.set(position[i][0],cube[i-1].position.y+geometries[i][1],position[i][2]);            
            }
            scene.add(cube[i]);
        };
    
        var controls = new THREE.OrbitControls(camera, renderer.domElement);
    
        function renderLoop() {
            //OrbitControlsを使う場合必須
            window.requestAnimationFrame(renderLoop);
            controls.update();
            
            //実際に描画
            renderer.render(scene, camera);
        }
        renderLoop();
    }
    
    calcBuildingPos(data);
    drawBuilding(data);
    
    function building(x,y,z,w,h,d)
    {
	    //コンストラクタとメンバ変数
	    this.x = x;
	    this.y = y;
        this.z = z;
        this.w = w;
        this.h = h;
        this.d = d;
    }
});