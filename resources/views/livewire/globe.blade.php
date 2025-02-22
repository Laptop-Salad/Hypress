<div>
    <div id="threeContainer" class="w-[100vw] h-[100vh]"></div>

    <script type="module">
        import * as THREE from 'three';
        import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
        import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

        var scene = new THREE.Scene();
        var camera = new THREE.PerspectiveCamera(0.5, window.innerWidth / window.innerHeight, 1, 1000);
        camera.position.set(0, 0, 500);
        var renderer = new THREE.WebGLRenderer({
            antialias: true
        });
        renderer.setClearColor(0x87CEEB);
        var canvas = renderer.domElement
        document.getElementById('threeContainer').appendChild(canvas);

        var controls = new OrbitControls(camera, renderer.domElement);

        var light = new THREE.HemisphereLight( 0xffffff, 0xffffff, 2.5 );
        scene.add( light );

        var loader = new GLTFLoader();

        loader.load('{{asset('img/globe/earth.gltf')}}', function (gltf) {
            console.log(gltf);
            const sphere = gltf.scene;
            scene.add(sphere);

            // Compute bounding box to find sphere size
            const bbox = new THREE.Box3().setFromObject(sphere);
            const sphereCenter = new THREE.Vector3();
            const sphereSize = new THREE.Vector3();
            bbox.getCenter(sphereCenter);
            bbox.getSize(sphereSize);

            const sphereRadius = Math.max(sphereSize.x, sphereSize.y, sphereSize.z) / 2;

            // Create Cube
            const cubeSize = sphereRadius * 0.2; // Cube size relative to sphere
            const cubeGeometry = new THREE.BoxGeometry(cubeSize, cubeSize, cubeSize);
            const cubeMaterial = new THREE.MeshStandardMaterial({ color: 0xff0000 });
            const cube = new THREE.Mesh(cubeGeometry, cubeMaterial);

            // Position cube on top of the sphere
            cube.position.set(
                sphereCenter.x,
                sphereCenter.y + sphereRadius + (cubeSize / 2),
                sphereCenter.z
            );

            scene.add(cube);

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
            const phi = (90 - lat) * (Math.PI / 180);
            const theta = (lon + 180) * (Math.PI / 180);

            const x = radius * Math.sin(phi) * Math.cos(theta);
            const y = radius * Math.cos(phi);
            const z = radius * Math.sin(phi) * Math.sin(theta);

            return new THREE.Vector3(x, y, z);
        }
    </script>
</div>
