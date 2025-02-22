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

            sphere.position.set(0, 0, 0);

            // sphere.rotation.y = Math.PI;
            // sphere.rotation.x = -Math.PI / 2;

            scene.add(sphere);

            // orientation
            const bbox = new THREE.Box3().setFromObject(sphere);
            const sphereCenter = new THREE.Vector3();
            const sphereSize = new THREE.Vector3();
            bbox.getCenter(sphereCenter);
            bbox.getSize(sphereSize);

            const sphereRadius = Math.max(sphereSize.x, sphereSize.y, sphereSize.z) / 2;

            /** Pipelines **/
            const pipelines = @json($this->pipelines);

            for (let i = 0; i < pipelines.length; i++) {
                placePipeline(pipelines[i], scene, sphereRadius, sphereCenter);
            }

            /** Assets **/
            const assets = @json($this->assets);

            for (let i = 0; i < assets.length; i++) {
                placeAsset(scene, assets[i]['coordinates']['longitude'], assets[i]['coordinates']['latitude'], sphereRadius, sphereCenter);
            }
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
            let coords = {
                lat: THREE.MathUtils.degToRad(90 - lat),
                lon: THREE.MathUtils.degToRad(-lon + 180)
            };

            return new THREE.Vector3().setFromSphericalCoords(
                radius,
                coords.lat,
                coords.lon
            );
        }

        function placePipeline(subseaPipeline, scene, sphereRadius, sphereCenter) {
            loader.load('{{asset('img/pipeline/pipeline.gltf')}}', function (gltf) {
                const startingCords = {
                    long: subseaPipeline['start_coordinates']['longitude'],
                    lat: subseaPipeline['start_coordinates']['latitude'],
                };

                const endingCords = {
                    long: subseaPipeline['end_coordinates']['longitude'],
                    lat: subseaPipeline['end_coordinates']['latitude'],
                };

                const pipelineSize = sphereRadius * 0.05;

                const startingPosition = convertToCartesian(startingCords.lat, startingCords.long, sphereRadius + (pipelineSize / 2));
                const endingPosition = convertToCartesian(startingCords.lat, startingCords.long, sphereRadius + (pipelineSize / 2));

                const pipeline = generatePipelineSegment(gltf.scene, startingPosition, endingPosition, sphereRadius, endingCords);

                scene.add(pipeline);
            }, undefined, function (error) {
                console.error(error);
            });
        }

        function generatePipelineSegment(pipelineObj, startingPosition, endingPosition, sphereRadius, endingCords) {
            const scale = 0.05;
            pipelineObj.scale.set(scale, scale, scale);

            pipelineObj.position.copy(startingPosition);
            pipelineObj.lookAt(convertToCartesian(endingCords.lat, endingCords.long, sphereRadius + (sphereRadius * 0.05 / 2)));

            return pipelineObj;
        }

        function placeObject(long, lat, scene, sphereRadius, sphereCenter) {
            const position = convertToCartesian(lat, long, sphereRadius + (cubeSize / 2));

            cube.position.copy(position);

            cube.lookAt(sphereCenter);

            scene.add(cube);
        }

        function placeAsset(scene, long, lat, radius, center) {
            loader.load('{{asset('img/assets/assets.gltf')}}', function (gltf) {
                const asset = gltf.scene;
                const position = convertToCartesian(lat, long, radius);

                asset.position.copy(position);

                const scale = 0.05;
                asset.scale.set(scale, scale, scale);

                asset.lookAt(center);

                scene.add(asset);
            }, undefined, function (error) {
                console.error(error);
            });
        }
    </script>
</div>
