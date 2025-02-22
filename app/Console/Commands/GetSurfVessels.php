<?php

namespace App\Console\Commands;

use App\Models\PointsOfInterest;
use App\Models\SurfVessel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetSurfVessels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:get-surf-vessels';

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
}
