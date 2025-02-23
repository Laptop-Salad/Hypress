<div>
    @push('head-stuff')
        <script src="https://cesium.com/downloads/cesiumjs/releases/1.126/Build/Cesium/Cesium.js"></script>
        <link href="https://cesium.com/downloads/cesiumjs/releases/1.126/Build/Cesium/Widgets/widgets.css" rel="stylesheet">
    @endpush

    <div id="cesiumContainer"></div>

        <!-- Modal Trigger Button -->
        <button id="openModal" class="bg-blue-500 text-white p-2 rounded">Open Modal</button>

        <!-- Modal -->
        <div id="myModal" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 hidden">
            <div class="bg-white rounded-lg p-8 w-96">
                <div class="flex justify-between">
                    <h2 id="title" class="text-xl font-semibold"></h2>
                    <button id="closeModal" class="text-gray-400 p-2 rounded">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div>
                    <a id="fullInfoPage" href="" target="_blank" class="text-blue-500 underline">
                        View full information page
                        <span id="type"></span>

                        <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                    </a>
                </div>
            </div>
        </div>


    @push('head-stuff')
        <script src="https://cesium.com/downloads/cesiumjs/releases/1.126/Build/Cesium/Cesium.js"></script>
        <link href="https://cesium.com/downloads/cesiumjs/releases/1.126/Build/Cesium/Widgets/widgets.css" rel="stylesheet">
    @endpush

    <div id="cesiumContainer"></div>
    <script type="module">
        const closeModal = document.getElementById('closeModal');

        closeModal.addEventListener('click', function () {
            document.getElementById('myModal').style.display = 'none';
        })

        Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI1ZTk0NTMxMy02NDQ5LTRiN2QtOGFjOC00YWE0N2Q5YWY3MzIiLCJpZCI6Mjc4MzA3LCJpYXQiOjE3NDAyNjgyODN9.q9MjXFXh63aczbsyKl9qD6j5-HMKmtItDnw1krBwMVk';

        // Initialize the Cesium Viewer in the HTML element with the `cesiumContainer` ID.
        const viewer = new Cesium.Viewer('cesiumContainer', {
            terrain: Cesium.Terrain.fromWorldTerrain(),
        });

        // Add Cesium OSM Buildings, a global 3D buildings layer.
        const buildingTileset = await Cesium.createOsmBuildingsAsync();
        viewer.scene.primitives.add(buildingTileset);

        /** Pipelines **/

        const pipelines = @json($pipelines);
        pipelines.forEach(pipeline => {
            let startCoords = {
                lat: pipeline['start_coordinates']['latitude'],
                long: pipeline['start_coordinates']['longitude'],
            };

            let endCoords = {
                lat: pipeline['end_coordinates']['latitude'],
                long: pipeline['end_coordinates']['longitude'],
            };

            let positions = [];
            const steps = 40; // Number of interpolated points

            for (let i = 0; i <= steps; ++i) {
                let t = i / steps;
                let interpolatedLat = Cesium.Math.lerp(startCoords.lat, endCoords.lat, t);
                let interpolatedLong = Cesium.Math.lerp(startCoords.long, endCoords.long, t);
                positions.push(Cesium.Cartesian3.fromDegrees(interpolatedLong, interpolatedLat));
            }

            viewer.entities.add({
                type: 'pipeline',
                id: pipeline['id'],
                name : pipeline['name'],
                model: {
                    uri: '/img/pipeline/pipeline.gltf',
                    scale: 1.0,
                    minimumPixelSize: 64,
                },
                description: `
                    <h3>Pipeline Info</h3>
                    <a href="pipeline/${pipeline["id"]}" target="_blank">See full details</a>
                    <p><b>Start:</b> ${startCoords.lat.toFixed(4)}, ${startCoords.long.toFixed(4)}</p>
                    <p><b>End:</b> ${endCoords.lat.toFixed(4)}, ${endCoords.long.toFixed(4)}</p>
                `,
                polyline: {
                    positions: positions,
                    width: 10.0,
                    material: new Cesium.PolylineGlowMaterialProperty({
                        color: Cesium.Color.DEEPSKYBLUE,
                        glowPower: 0.25,
                    }),
                },
            });
        });


        // Popup element
        const popup = document.getElementById('myModal');
        const type = document.getElementById('type');
        const fullInfoPage = document.getElementById('fullInfoPage');
        const title = document.getElementById('title');

        // Handle mouse clicks on the scene
        const handler = new Cesium.ScreenSpaceEventHandler(viewer.scene.canvas);

        handler.setInputAction(function (click) {
            // Get the position of the mouse click in the world
            const pickedObject = viewer.scene.pick(click.position);

            // Check if an object was clicked
            if (Cesium.defined(pickedObject)) {
                let entity = pickedObject.id;
                popup.style.display = 'flex';

                if (entity.type === 'pipeline') {
                    title.innerHTML = entity.name;
                    type.innerHTML = 'pipeline';
                    fullInfoPage.setAttribute('href', `pipelines/${entity.id}`)
                }
            } else {
                // Hide the popup if no object is clicked
                popup.style.display = 'none';
            }
        }, Cesium.ScreenSpaceEventType.LEFT_CLICK);


        const assets = @json($this->assets);

        assets.forEach((asset) => {
            const { latitude, longitude } = asset.coordinates;
            viewer.entities.add({
                name: asset.name,
                position: Cesium.Cartesian3.fromDegrees(longitude, latitude),
                model: {
                    uri: '/img/assets/assets.gltf',
                    scale: 1.0,
                    minimumPixelSize: 64,
                },

            });
        });

        const vessels = @json($this->vessels);

        vessels.forEach((vessel) => {
            const { latitude, longitude } = vessel.coordinates;
            viewer.entities.add({
                name: vessel.name,
                position: Cesium.Cartesian3.fromDegrees(longitude, latitude),
                model: {
                    uri: '/img/vessel/boat.gltf',
                    scale: 1.0,
                    minimumPixelSize: 64,
                },

            });
        });



        // Embed points of interest data from Livewire/PHP
        const pointsOfInterest = @json($this->points_of_interest);

        // Loop through each point of interest and add it to the viewer
        pointsOfInterest.forEach((poi) => {
            // Make sure coordinates are in the expected format (object with latitude and longitude)
            const { latitude, longitude } = poi.coordinates;
            viewer.entities.add({
                name: poi.name,
                position: Cesium.Cartesian3.fromDegrees(longitude, latitude),
                model: {
                    uri: '/img/pointsOfInterest/pointsOfInterest.gltf',
                    scale: 1.0,
                    minimumPixelSize: 64,
                },
                description: poi.description
            });
        });
    </script>
</div>
