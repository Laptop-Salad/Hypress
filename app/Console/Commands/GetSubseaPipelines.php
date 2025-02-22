<?php

namespace App\Console\Commands;

use App\Models\Alert;
use App\Models\SubseaPipeline;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetSubseaPipelines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:get-subsea-pipelines';

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
        $response = Http::get('https://elementz.rguhack.uk/subseaPipelines');

        foreach ($response->json() as $pipeline) {
            $subsea_pipeline = SubseaPipeline::create([
                'name' => $pipeline['name'],
                'start_coordinates' => $pipeline['start_coordinates']['coordinates'],
                'end_coordinates' => $pipeline['end_coordinates']['coordinates'],
                'start_depth' => $pipeline['start_coordinates']['depth'],
                'end_depth' => $pipeline['end_coordinates']['depth'],
                'health' => $pipeline['health'],
                'pressure' => $pipeline['pressure'],
                'temperature' => $pipeline['temperature'],
                'flow_rate' => $pipeline['flow_rate'],
                'last_inspection' => $pipeline['last_inspection'],
                'next_maintenance' => $pipeline['next_maintenance'],
                'open_anomaly_count' => $pipeline['open_anomaly_count'],
            ]);

            foreach ($pipeline['alerts'] as $alert) {
                Alert::create([
                    'alertable_id' => $subsea_pipeline->id,
                    'alertable_type' => SubseaPipeline::class,
                    'alert' => $alert
                ]);
            }
        }
    }
}
