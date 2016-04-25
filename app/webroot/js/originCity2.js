$(function()
{
	var scene = new THREE.Scene();
    var camera = new THREE.PerspectiveCamera(75, 600 / 400, 1, 1000);
 
    camera.position.set(-100, 50, 100);
 
    renderer = new THREE.WebGLRenderer();
    renderer.setSize(655, 437);
 	document.getElementById('canvas-wrapper').appendChild(renderer.domElement);

    var lightPos = [
        [0,10,10],
        [0,10,-10],
        [10,10,0],
        [-10,10,0],
    ];
    
    for (var i = 0; i < lightPos.length; i++) {
        var directionalLight = new THREE.DirectionalLight('#FFFFFF', 1);
        directionalLight.position.set(lightPos[i][0],  lightPos[i][1], lightPos[i][2]);
        scene.add(directionalLight);
    }
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
 
    function render() {
        requestAnimationFrame(render);
 
        for (var i = 0; i < cube.length; i++) {
            //cube[i].rotation.x += 0.01; // 追加
            //cube[i].rotation.y += 0.01; // 追加
        };
 
        controls.update();
        renderer.render(scene, camera);
    }
    render();
});