<div>
    <x-slot name="header" class="min-h-32">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('3D View') }}
            </h2>
        </div>

        <div class="mt-6">
            <div class="max-w-sm min-w-40">
                <label for="asset_type_filter" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                <select wire:model.live="asset_type" id="asset_type_filter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="all">All Asset Types</option>
                    <option value="assets">Subsea Assets</option>
                    <option value="pipelines">Subsea Pipelines</option>
                    <option value="vessels">Surf Vessels</option>
                    <option value="pois">Point of Interests</option>
                </select>
            </div>
        </div>
    </x-slot>

    @push('head-stuff')
        <script src="https://cesium.com/downloads/cesiumjs/releases/1.126/Build/Cesium/Cesium.js"></script>
        <link href="https://cesium.com/downloads/cesiumjs/releases/1.126/Build/Cesium/Widgets/widgets.css" rel="stylesheet">
    @endpush

    <div id="cesiumContainer"></div>
        <!-- Modal -->
        <div id="myModal" class="fixed inset-0 flex justify-center items-center bg-gray-800 bg-opacity-50 hidden">
            <div class="bg-white rounded-lg p-8 w-[90vw] h-[80vh]">
                <div class="flex justify-between">
                    <h2 id="title" class="text-xl font-semibold"></h2>
                    <button id="closeModal" class="text-gray-400 p-2 rounded">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div>
                    <a id="fullInfoPage" href="" target="_blank" class="text-blue-500 underline">
                        View full information page of
                        <span id="type"></span>

                        <i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                    </a>

                    <x-short-pipeline />
                    <x-short-poi />
                    <x-short-asset />
                    <x-short-vessel />
                </div>
            </div>
        </div>

    <script type="module">
        let pipelines = @json($this->pipelines);
        let vessels = @json($this->vessels);
        let assets = @json($this->assets);
        let pointsOfInterest = @json($this->points_of_interest);

        const closeModal = document.getElementById('closeModal');

        closeModal.addEventListener('click', function () {
            document.getElementById('myModal').style.display = 'none';
        })

        // FILTER TYPE
        const typeFilter = document.getElementById('asset_type_filter');

        typeFilter.addEventListener('change', function () {
            if (typeFilter.value !== 'all') {
                vessels = @json([]);
                assets = @json([]);
                pointsOfInterest = @json([]);
                pipelines = @json([]);

                if (typeFilter.value === 'pipelines') {
                    pipelines = @json($this->pipelines);
                } else if (typeFilter.value === 'vessels') {
                    vessels = @json($this->vessels);
                } else if (typeFilter.value === 'assets') {
                    assets = @json($this->assets);
                } else if (typeFilter.value === 'pois') {
                    pointsOfInterest = @json($this->points_of_interest);
                }
            } else {
                pipelines = @json($this->pipelines);
                vessels = @json($this->vessels);
                assets = @json($this->assets);
                pointsOfInterest = @json($this->points_of_interest);
            }

            render();
        })

        async function render() {
            document.getElementById('cesiumContainer').innerHTML = '';
            Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI1ZTk0NTMxMy02NDQ5LTRiN2QtOGFjOC00YWE0N2Q5YWY3MzIiLCJpZCI6Mjc4MzA3LCJpYXQiOjE3NDAyNjgyODN9.q9MjXFXh63aczbsyKl9qD6j5-HMKmtItDnw1krBwMVk';

            // Initialize the Cesium Viewer in the HTML element with the `cesiumContainer` ID.
            const viewer = new Cesium.Viewer('cesiumContainer', {
                terrain: Cesium.Terrain.fromWorldTerrain(),
            });

            // Add Cesium OSM Buildings, a global 3D buildings layer.
            const buildingTileset = await Cesium.createOsmBuildingsAsync();
            viewer.scene.primitives.add(buildingTileset);




            /** Pipelines **/
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
                    dbId: pipeline['id'],
                    name: pipeline['name'],
                    pipeline: pipeline,
                    model: {
                        uri: '/img/pipeline/pipeline.gltf',
                        scale: 1.0,
                        minimumPixelSize: 64,
                    },
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

            // pipeline spans
            const pipelineTemp = document.getElementById('pipelineTemperature');
            const pipelineFlow = document.getElementById('pipelineFlowrate');
            const pipelineAnomalies = document.getElementById('pipelineAnomalyCount');
            const pipelinePressure = document.getElementById('pipelinePressure');
            const pipelineHealth = document.getElementById('pipelineHealth');

            // asset spans
            const assetTemp = document.getElementById('assetTemperature');
            const assetFlow = document.getElementById('assetFlowrate');
            const assetAnomalies = document.getElementById('assetAnomalyCount');
            const assetPressure = document.getElementById('assetPressure');
            const assetHealth = document.getElementById('assetHealth');

            // vessel spans
            const vesselETA = document.getElementById('vesselETA');
            const vesselStatus = document.getElementById('vesselStatus');
            const vesselDestination = document.getElementById('vesselDestination');

            // poi spans
            const poiDescription = document.getElementById('poiDescription');

            // Handle mouse clicks on the scene
            const handler = new Cesium.ScreenSpaceEventHandler(viewer.scene.canvas);

            handler.setInputAction(function (click) {
                document.getElementById('pipeline').style.display = 'none';
                document.getElementById('poi').style.display = 'none';
                document.getElementById('asset').style.display = 'none';
                document.getElementById('vessel').style.display = 'none';

                // Get the position of the mouse click in the world
                const pickedObject = viewer.scene.pick(click.position);

                // Check if an object was clicked
                if (Cesium.defined(pickedObject)) {
                    let entity = pickedObject.id;
                    popup.style.display = 'flex';

                    if (entity.type === 'pipeline') {
                        title.innerHTML = entity.name;
                        type.innerHTML = 'pipeline';
                        fullInfoPage.setAttribute('href', `pipelines/${entity.dbId}`)

                        pipelineTemp.innerHTML = entity.pipeline.temperature;
                        pipelineFlow.innerHTML = entity.pipeline.flow_rate;
                        pipelineAnomalies.innerHTML = entity.pipeline.open_anomaly_count;
                        pipelinePressure.innerHTML = entity.pipeline.pressure;
                        const PipelineHealth = {
                            1: 'Healthy',
                            2: 'Degraded',
                            3: 'Critical',
                            4: 'Offline',
                            5: 'Unknown',
                            from(value) {
                                return this[value] || 'Unknown';
                            }
                        };

                        pipelineHealth.innerHTML = PipelineHealth.from(entity.pipeline.health);

                        document.getElementById('pipeline').style.display = 'block';
                    } else if (entity.type === 'asset') {
                        title.innerHTML = entity.name;
                        type.innerHTML = 'asset';
                        fullInfoPage.setAttribute('href', `assets/${entity.dbId}`)

                        assetTemp.innerHTML = entity.asset.temperature;
                        assetFlow.innerHTML = entity.asset.flow_rate;
                        assetAnomalies.innerHTML = entity.asset.open_anomaly_count;
                        assetPressure.innerHTML = entity.asset.pressure;
                        const PipelineHealth = {
                            1: 'Healthy',
                            2: 'Degraded',
                            3: 'Critical',
                            4: 'Offline',
                            5: 'Unknown',
                            from(value) {
                                return this[value] || 'Unknown';
                            }
                        };

                        assetHealth.innerHTML = PipelineHealth.from(entity.asset.health);

                        document.getElementById('asset').style.display = 'block';
                    } else if (entity.type === 'vessel') {
                        title.innerHTML = entity.name;
                        type.innerHTML = 'vessel';
                        fullInfoPage.setAttribute('href', `vessels/${entity.dbId}`)

                        const date = new Date(entity.vessel.eta);

                        vesselETA.innerHTML = date.toLocaleString();
                        vesselStatus.innerHTML = entity.vessel.status;
                        vesselDestination.innerHTML = entity.vessel.destination;

                        document.getElementById('vessel').style.display = 'block';
                    } else if (entity.type === 'poi') {
                        title.innerHTML = entity.name;
                        type.innerHTML = 'point of interest';
                        poiDescription.innerHTML = entity.description;
                        fullInfoPage.setAttribute('href', `pois/${entity.dbId}`)

                        document.getElementById('poi').style.display = 'block';
                    }
                } else {
                    // Hide the popup if no object is clicked
                    popup.style.display = 'none';
                }
            }, Cesium.ScreenSpaceEventType.LEFT_CLICK);


            assets.forEach((asset) => {
                const { latitude, longitude } = asset.coordinates;
                viewer.entities.add({
                    type: 'asset',
                    dbId: asset['id'],
                    name: asset.name,
                    asset: asset,
                    position: Cesium.Cartesian3.fromDegrees(longitude, latitude),
                    model: {
                        uri: '/img/assets/assets.gltf',
                        scale: 1.0,
                        minimumPixelSize: 64,
                    },

                });
            });

            vessels.forEach((vessel) => {
                const { latitude, longitude } = vessel.coordinates;
                viewer.entities.add({
                    type: 'vessel',
                    dbId: vessel['id'],
                    name: vessel.name,
                    vessel: vessel,
                    position: Cesium.Cartesian3.fromDegrees(longitude, latitude),
                    model: {
                        uri: '/img/vessel/boat.gltf',
                        scale: 1.0,
                        minimumPixelSize: 64,
                    },

                });
            });

            // Loop through each point of interest and add it to the viewer
            pointsOfInterest.forEach((poi) => {
                // Make sure coordinates are in the expected format (object with latitude and longitude)
                const { latitude, longitude } = poi.coordinates;
                viewer.entities.add({
                    type: 'poi',
                    dbId: poi['id'],
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
        }

        render();
    </script>
</div>
