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

            sphere.position.set(0, 0, 0);

            sphere.rotation.x = -Math.PI / 2;

            // orientationwqa6§§§§§§§§
            const bbox = new THREE.Box3().setFromObject(sphere);
            const sphereCenter = new THREE.Vector3();
            const sphereSize = new THREE.Vector3();
            bbox.getCenter(sphereCenter);
            bbox.getSize(sphereSize);

            const sphereRadius = Math.max(sphereSize.x, sphereSize.y, sphereSize.z) / 2;

            // RGU Cords
            const lat = 57.118696610829296;
            const long = -2.1350145324081367;

            placeObject(long, lat, scene, sphereRadius, sphereCenter);
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
            // option 1: mathy way
            let x = radius * Math.cos(lat) * Math.cos(lon)
            let y = radius * Math.cos(lat) * Math.sin(lon)
            let z = radius * Math.sin(lat);

            console.log(new THREE.Vector3(x, y, z));


            // option 2: threejs way
            let coords = {
                lat: THREE.MathUtils.degToRad(90 - lat),
                lon: THREE.MathUtils.degToRad(lon)
            };

            return new THREE.Vector3().setFromSphericalCoords(
                radius,
                coords.lat,
                coords.lon
            );
        }

        function placeObject(long, lat, scene, sphereRadius, sphereCenter) {
            const cubeSize = sphereRadius * 0.05;
            const cubeGeometry = new THREE.BoxGeometry(cubeSize, cubeSize, cubeSize);
            const cubeMaterial = new THREE.MeshStandardMaterial({ color: 0xff0000 });
            const cube = new THREE.Mesh(cubeGeometry, cubeMaterial);

            const position = convertToCartesian(lat, long, sphereRadius + (cubeSize / 2));

            cube.position.copy(position);

            cube.lookAt(sphereCenter);

            scene.add(cube);
        }
    </script>
</div>
