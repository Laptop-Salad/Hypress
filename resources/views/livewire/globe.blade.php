<div>
    <div id="cesiumContainer"></div>
    <script type="module">
        Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI1ZTk0NTMxMy02NDQ5LTRiN2QtOGFjOC00YWE0N2Q5YWY3MzIiLCJpZCI6Mjc4MzA3LCJpYXQiOjE3NDAyNjgyODN9.q9MjXFXh63aczbsyKl9qD6j5-HMKmtItDnw1krBwMVk';

        // Initialize the Cesium Viewer in the HTML element with the `cesiumContainer` ID.
        const viewer = new Cesium.Viewer('cesiumContainer', {
            terrain: Cesium.Terrain.fromWorldTerrain(),
        });

        // Add Cesium OSM Buildings, a global 3D buildings layer.
        const buildingTileset = await Cesium.createOsmBuildingsAsync();
        viewer.scene.primitives.add(buildingTileset);

        /** Pipelines **/
        let pipelines = @json($this->pipelines);

        for (let i = 0; i < pipelines.length; i++) {
            let pipeline = pipelines[i];

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
                // Linear interpolation factor (0 to 1)
                let t = i / steps;

                // Interpolated latitude and longitude
                let interpolatedLat = Cesium.Math.lerp(startCoords.lat, endCoords.lat, t);
                let interpolatedLong = Cesium.Math.lerp(startCoords.long, endCoords.long, t);

                positions.push(Cesium.Cartesian3.fromDegrees(interpolatedLong, interpolatedLat));
            }

            viewer.entities.add({
                name : pipeline['name'],
                description: `
                    <h3>Pipeline Info</h3>
                    <a href="pipeline/${pipeline["id"]}" target="_blank">See the full information for this pipeline</a>
                    <p><b>Start Coordinates:</b> ${startCoords.lat.toFixed(4)}, ${startCoords.long.toFixed(4)}</p>
                    <p><b>End Coordinates:</b> ${endCoords.lat.toFixed(4)}, ${endCoords.long.toFixed(4)}</p>
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
        }

        //
        // viewer.entities.add({
        //     position: Cesium.Cartesian3.fromDegrees(2.6, 60.2),
        //     ellipse: {
        //         semiMinorAxis: 100000.0,
        //         semiMajorAxis: 200000.0,
        //         height: 300.0,
        //         extrudedHeight: 700000.0,
        //         rotation: Cesium.Math.toRadians(-40.0),
        //         material: Cesium.Color.fromRandom({ alpha: 1.0 }),
        //     },
        // });

        {{--viewer.entities.add({--}}
        {{--    name: 'Subsea Asset',--}}
        {{--    position: Cesium.Cartesian3.fromDegrees(2.6, 60.2),--}}
        {{--    model: {--}}
        {{--        uri: '{{asset('img/assets/assets.gltf')}}',--}}
        {{--        scale: 1,--}}
        {{--        minimumPixelSize: 64,--}}
        {{--    },--}}
        {{--});--}}

        // Add a test subsea asset (already working)
        viewer.entities.add({
            name: 'Subsea Asset',
            position: Cesium.Cartesian3.fromDegrees(2.6, 60.2),
            model: {
                uri: '{{ asset("img/assets/assets.gltf") }}',
                scale: 1,
                minimumPixelSize: 64,
            },
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