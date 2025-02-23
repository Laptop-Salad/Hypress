<div>
    <div id="cesiumContainer"></div>

    <div id="cesiumContainer"></div>
    <script type="module">
        Cesium.Ion.defaultAccessToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI1ZTk0NTMxMy02NDQ5LTRiN2QtOGFjOC00YWE0N2Q5YWY3MzIiLCJpZCI6Mjc4MzA3LCJpYXQiOjE3NDAyNjgyODN9.q9MjXFXh63aczbsyKl9qD6j5-HMKmtItDnw1krBwMVk';

        // Initialize the Cesium Viewer in the HTML element with the `cesiumContainer` ID.
        const viewer = new Cesium.Viewer('cesiumContainer', {
            terrain: Cesium.Terrain.fromWorldTerrain(),
        });

        // Fly the camera to San Francisco at the given longitude, latitude, and height.
        // viewer.camera.flyTo({
        //     destination: Cesium.Cartesian3.fromDegrees(-122.4175, 37.655, 400),
        //     orientation: {
        //         heading: Cesium.Math.toRadians(0.0),
        //         pitch: Cesium.Math.toRadians(-15.0),
        //     }
        // });

        // Add Cesium OSM Buildings, a global 3D buildings layer.
        const buildingTileset = await Cesium.createOsmBuildingsAsync();
        viewer.scene.primitives.add(buildingTileset);

        // let positions = [];
        // for (let i = 0; i < 40; ++i) {
        //     positions.push(Cesium.Cartesian3.fromDegrees(2.6 + i, 60.2));
        // }
        //
        // viewer.entities.add({
        //     polyline: {
        //         positions: positions,
        //         width: 10.0,
        //         material: new Cesium.PolylineGlowMaterialProperty({
        //             color: Cesium.Color.DEEPSKYBLUE,
        //             glowPower: 0.25,
        //         }),
        //     },
        // });

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

        viewer.entities.add({
            name: 'Subsea Asset',
            position: Cesium.Cartesian3.fromDegrees(2.6, 60.2),
            model: {
                uri: '{{asset('img/assets/assets.gltf')}}',
                scale: 1,
                minimumPixelSize: 64,
            },
        });
    </script>
</div>
