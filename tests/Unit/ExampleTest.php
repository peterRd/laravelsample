<?php

namespace Tests\Unit;

use App\Models\Instrument;
use App\Models\Reading;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example to check whether invalidity is set correctly.
     *
     * @param $newazimuth The amount to be added to get to the new azimuth
     * @param $newdip The amount to be added to get the new dip
     * @param $expectedstate The expected 'invalid' state on the object.
     * @dataProvider testBasicTestProvider
     */
    public function testBasicTest($newazimuth, $newdip, $expectedstate)
    {
        // Initialise the state of the db
        $instrument = Instrument::factory()
            ->has(Reading::factory()->count(1))
            ->create();
        $firstreading = Reading::first();
        $azimuth = $firstreading->azimuth;
        $dip = $firstreading->dip;
        $time = Carbon::instance($firstreading->created_at);
        Reading::factory()
            ->count(4)
            ->for($instrument)
            ->state(function() use($time){
                return [
                    'created_at' => $time->add('1', 'min')
                ];
            })
            ->create();
        $readings = Reading::where('id','!=',$firstreading->id)
            ->orderBy('created_at', 'asc')
            ->limit(4)
            ->get();
        foreach ($readings as $newread) {
            $newread->dip = ++$dip;
            $newread->azimuth = ++$azimuth;
            $newread->save();
        }

        //Create the new record.
        $reading = Reading::factory()->for($instrument)
            ->state(function() use($dip, $azimuth, $time, $newdip, $newazimuth) {
                return [
                    'azimuth' => $azimuth + $newazimuth,
                    'dip' => Reading::avg('dip') + $newdip,
                    'created_at' => $time->add('1', 'min')
                ];
            })
            ->create();

        // Finally, check what the state of 'invalid'
        $this->assertEquals($expectedstate, $reading->invalid);
    }

    /**
     * Provider test the reading observer that auto sets the invalid state.
     *
     * @return array
     */
    public function testBasicTestProvider() {
        return [
            "Test with a valid dip and azimuth" => [
                4, 2, false
            ],
            "Test with a valid dip and invalid azimuth" => [
                6, 2, true
            ],
            "Test with an invalid dip and valid azimuth" => [
                4, 4, true
            ],
            "Test with an invalid dip and valid azimuth" => [
                7, 7, true
            ],
        ];
    }

    /**
     * Basic test for the main endpoint
     *
     * @param $endpoint
     * @param $asauthenticated
     * @dataProvider testEndpointsProvider
     */
    public function testEndpoints($type, $endpoint, $asauthenticated, $expectedStatus) {
        if ($asauthenticated) {
            $user = User::factory()->create();
            $response = $this->actingAs($user)->$type(route($endpoint, [1])); // We don't care what the parms are.
        } else {
            $response = $this->$type($endpoint);
        }
        $response->assertStatus($expectedStatus);
    }

    public function testEndpointsProvider() {
        return [
            'Unauthenticated user accessing home' => [
                'get', 'home', false, 302
            ],
            'Authenticated user accessing home' => [
                'get', 'home', true, 200
            ],
            'Unauthenticated user accessing instruments' => [
                'get', 'getinstruments', false, 404
            ],
            'Authenticated user accessing instruments' => [
                'get', 'getinstruments', true, 200
            ],
            'Authenticated user accessing readings' => [
                'get', 'readings', true, 200
            ],
            'Authenticated user accessing readings' => [
                'get', 'readings', false, 404
            ],
        ];
    }
}
