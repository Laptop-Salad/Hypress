<div>
    <div id="threeContainer" class="w-[100vw] h-[100vh]"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/109/three.min.js"></script>

    <script type="module">
        import * as THREE from 'three';
        import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
        import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(5, window.innerWidth / window.innerHeight, 1, 1000);
        camera.position.set(0, 0, 500);
        var renderer = new THREE.WebGLRenderer({
            antialias: true
        });
        renderer.setClearColor(0x808080);
        var canvas = renderer.domElement
        document.getElementById('threeContainer').appendChild(canvas);

        var controls = new OrbitControls(camera, renderer.domElement);

        var light = new THREE.HemisphereLight( 0xffffff, 0x080820, 1 );
        scene.add( light );

        var loader = new GLTFLoader();

        loader.load('{{asset('img/globe/earth.gltf')}}', function (gltf) {
            console.log(gltf);
            const sphere = gltf.scene;
            scene.add(sphere);

            // Assuming the sphere has a radius of 100 units (adjust based on your model)
            const sphereRadius = 100;

            // Create a marker (cube)
            const cubeSize = 5;
            const cubeGeometry = new THREE.BoxGeometry(cubeSize, cubeSize, cubeSize);
            const cubeMaterial = new THREE.MeshStandardMaterial({ color: 0xff0000 });
            const cube = new THREE.Mesh(cubeGeometry, cubeMaterial);
            scene.add(cube);

            // Convert lat/lon to Cartesian
            const latitude = 57.3224444540274;
            const longitude = -0.190915869492406;
            const cubePosition = convertToCartesian(latitude, longitude, sphereRadius + cubeSize / 2);

            // Position the cube
            cube.position.copy(cubePosition);

            // Orient the cube to face outward from the sphere
            cube.lookAt(cube.position.clone().multiplyScalar(2));

        }, undefined, function (error) {
            console.error(error);
        });


        render();

        function render() {
            if (resize(renderer)) {
                camera.aspect = canvas.clientWidth / canvas.clientHeight;
                camera.updateProjectionMatrix();
            }
            renderer.render(scene, camera);
            requestAnimationFrame(render);
        }

        function resize(renderer) {
            const canvas = renderer.domElement;
            const width = document.getElementById('threeContainer').clientWidth;
            const height = document.getElementById('threeContainer').clientHeight;
            const needResize = canvas.width !== width || canvas.height !== height;
            if (needResize) {
                renderer.setSize(width, height, false);
            }
            return needResize;
        }

        function convertToCartesian(lat, lon, radius) {
            const phi = (90 - lat) * (Math.PI / 180);  // polar angle
            const theta = (lon + 180) * (Math.PI / 180); // azimuthal angle

            const x = radius * Math.sin(phi) * Math.cos(theta);
            const y = radius * Math.cos(phi);
            const z = radius * Math.sin(phi) * Math.sin(theta);

            return new THREE.Vector3(x, y, z);
        }
    </script>
</div>
