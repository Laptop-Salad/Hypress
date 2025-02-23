<?php

use App\Enums\PipelineHealth;
use App\Models\Alert;
use App\Models\ConnectedSubseaAsset;
use App\Models\PointsOfInterest;
use App\Models\SubseaAsset;
use App\Models\SubseaPipeline;
use App\Models\SurfVessel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $response = Http::get('https://elementz.rguhack.uk/pointsOfInterest');

        foreach ($response->json() as $point) {
            PointsOfInterest::create([
                'coordinates' => $point['coordinates'],
                'name' => $point['name'],
                'description' => $point['description'],
            ]);
        }

        $response = Http::get('https://elementz.rguhack.uk/subseaAssets');

        foreach ($response->json() as $asset) {
            $subsea_asset = SubseaAsset::create([
                'coordinates' => $asset['coordinates']['coordinates'],
                'name' => $asset['name'],
                'depth' => $asset['coordinates']['depth'],
                'health' => PipelineHealth::tryFromName($asset['health']),
                'pressure' => $asset['pressure'],
                'temperature' => $asset['temperature'],
                'flow_rate' => $asset['flow_rate'],
                'last_inspection' => $asset['last_inspection'],
                'next_maintenance' => $asset['next_maintenance'],
                'open_anomaly_count' => $asset['open_anomaly_count'],
                'workpacks_at_site_count' => $asset['workpacks_at_site_count'],
            ]);

            foreach ($asset['alerts'] as $alert) {
                if ($alert === 'None') { continue; }

                Alert::create([
                    'alertable_id' => $subsea_asset->id,
                    'alertable_type' => SubseaAsset::class,
                    'alert' => $alert
                ]);
            }
        }

        foreach ($response->json() as $asset) {
            $subsea_asset = SubseaAsset::where('name', $asset['name'])->first();

            foreach ($asset['connected_assets'] as $connected_asset_name) {
                $connected_asset = SubseaAsset::where('name', $connected_asset_name)->first();

                ConnectedSubseaAsset::create([
                    'subsea_asset_id' => $subsea_asset->id,
                    'connected_asset_id' => $connected_asset->id,
                ]);
            }
        }

        $response = Http::get('https://elementz.rguhack.uk/subseaPipelines');

        foreach ($response->json() as $pipeline) {
            $subsea_pipeline = SubseaPipeline::create([
                'name' => $pipeline['name'],
                'start_coordinates' => $pipeline['start_coordinates']['coordinates'],
                'end_coordinates' => $pipeline['end_coordinates']['coordinates'],
                'start_depth' => $pipeline['start_coordinates']['depth'],
                'end_depth' => $pipeline['end_coordinates']['depth'],
                'health' => PipelineHealth::tryFromName($pipeline['health']),
                'pressure' => $pipeline['pressure'],
                'temperature' => $pipeline['temperature'],
                'flow_rate' => $pipeline['flow_rate'],
                'last_inspection' => $pipeline['last_inspection'],
                'next_maintenance' => $pipeline['next_maintenance'],
                'open_anomaly_count' => $pipeline['open_anomaly_count'],
            ]);

            foreach ($pipeline['alerts'] as $alert) {
                if ($alert === 'None') { continue; }

                Alert::create([
                    'alertable_id' => $subsea_pipeline->id,
                    'alertable_type' => SubseaPipeline::class,
                    'alert' => $alert
                ]);
            }
        }

        $response = Http::get('https://elementz.rguhack.uk/surfVessels');

        foreach ($response->json() as $surf_vessel) {
            SurfVessel::create([
                'name' => $surf_vessel['name'],
                'coordinates' => $surf_vessel['coordinates'],
                'heading' => $surf_vessel['heading'],
                'speed' => $surf_vessel['speed'],
                'destination' => $surf_vessel['destination'],
                'eta' => $surf_vessel['eta'],
                'status' => $surf_vessel['status'],
                'last_inspection' => $surf_vessel['last_inspection'],
                'fuel_level' => $surf_vessel['fuel_level'],
                'wind_speed' => $surf_vessel['weather']['wind_speed'],
                'wave_height' => $surf_vessel['weather']['wave_height'],
                'temperature' => $surf_vessel['weather']['temperature'],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
