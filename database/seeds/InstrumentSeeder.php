<?php

use Illuminate\Database\Seeder;
use App\Models\Reading;
use App\Models\Instrument;

class InstrumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instrument::factory()->count(3)
            ->has(Reading::factory()->count(50))
            ->create();
    }
}
