<?php

namespace App\Console\Commands;

use App\Models\PointsOfInterest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetPointsOfInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api:get-points-of-interest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all points of interests and load into db';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://elementz.rguhack.uk/pointsOfInterest');

        foreach ($response->json() as $point) {
            PointsOfInterest::create([
                'coordinates' => $point['coordinates'],
                'name' => $point['name'],
                'description' => $point['description'],
            ]);
        }
    }
}