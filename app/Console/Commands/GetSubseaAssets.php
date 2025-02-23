<?php

namespace App\Console\Commands;

use App\Enums\PipelineHealth;
use App\Models\Alert;
use App\Models\ConnectedSubseaAsset;
use App\Models\SubseaAsset;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetSubseaAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:get-subsea-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
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
    }
}
