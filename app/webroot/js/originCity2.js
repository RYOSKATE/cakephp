$(function()
{


	var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(75, 600 / 400, 1, 1000);
 
        camera.position.set(50, 0, 100);
 
        renderer = new THREE.WebGLRenderer();
        renderer.setSize(655, 437);
 	document.getElementById('canvas-wrapper').appendChild(renderer.domElement);

        var directionalLight = new THREE.DirectionalLight('#ffffff', 1);
        directionalLight.position.set(0, 7, 10);
        scene.add(directionalLight);
 
        var geometry = new THREE.BoxGeometry(12, 12, 12);
        var material = new THREE.MeshPhongMaterial({color: 'white'});
 
        var cube = [];
        var position = [
			
			//画面上方向に+y
			//画面右方向に+x
			//手前方向に+z
			//L
            [-15,0,0],
            [-15,15,0],
            [-15,30,0],
            [-15,45,0],
            [-15,60,0],
			
			
            [0,0,0],
            [15,0,0],
            [30,0,0],
			
			//I
            [60,0,0],
            [60,15,0],
            [60,30,0],
            [60,45,0],
            [60,60,0],
			
			
			//G
            [90,60,0],
            [90,45,0],
            [90,30,0],
            [90,15,0],
            [90,0,0],
            [105,0,0],
            [120,0,0],
            [135,0,0],
            [105,60,0],
            [120,60,0],
            [135,45,0],
            [135,15,0],
        ];
 
        for (var i = 0; i < position.length; i++) {
			     var material = new THREE.MeshPhongMaterial({color: 'white'});
            cube[i] = new THREE.Mesh(geometry, material);
            cube[i].position.set(position[i][0]-60,position[i][1]-30,position[i][2]);
            scene.add(cube[i]);
        };
 
        var controls = new THREE.OrbitControls(camera, renderer.domElement);
 
        function render() {
            requestAnimationFrame(render);
 
            for (var i = 0; i < cube.length; i++) {
                cube[i].rotation.x += 0.01; // 追加
                cube[i].rotation.y += 0.01; // 追加
            };
 
            controls.update();
            renderer.render(scene, camera);
        }
        render();
});