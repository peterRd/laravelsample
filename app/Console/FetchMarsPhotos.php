<?php

namespace App\Console;

use Illuminate\Support\Facades\Http;
use App\Events\PhotosReceived;

class FetchMarsPhotos {
    static $rovers = [
        'curiosity',
        'opportunity',
        'spirit'
    ];

    static $api_key = 'DEMO_KEY'; // Ideally store in db.

    public function __invoke() {
        $currentsol = 0; // Last received sol fetch from DB.
        $newrover = "spirit"; // Last received rover fetch from DB.
        $maxsol = $currentsol;

        // Get the latest sol along with the rover that took it.
        foreach(self::$rovers as $rover) {
            $data = $this->get_rover_manifest($rover);
            if ($data['max_sol'] > $maxsol) {
                $maxsol = $data['max_sol'];
                $newrover = $rover;
            }
        }

        // Make sure to check that the 2 values don't match up.
        if ($maxsol > $currentsol) {
            $page = 1;
            while($photos = $this->get_rover_photos($newrover, $maxsol, $page)) {
                // Send an event that we have received new photos.
                PhotosReceived::dispatch($photos);
                $page++;
            }

            // Store $maxsol into db.
        }
    }

    private function get_rover_manifest(string $rover) {
        $manifesturl = "https://api.nasa.gov/mars-photos/api/v1/manifiests/$rover";
        $response = Http::get($manifesturl, [
            'api_key' => self::$api_key
        ]);
        return $response->json('photo_manifest');
    }

    private function get_rover_photos(string $rover, int $sol, int $page = 1) {
        //Fetch the photos
        $response = Http::get("https://api.nasa.gov/mars-photos/api/v1/rovers/$rover/photos", [
            'sol' => $sol,
            'page' => $page,
            'api_key' => self::$api_key
        ]);
        return $response->json('photos');
    }
}
