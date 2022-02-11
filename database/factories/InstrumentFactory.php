<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InstrumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city(),
            'latitude' => $this->faker->latitude(),
            'longtitude' => $this->faker->longitude(),
            'hole_description' => $this->faker->text(100),
            'dip' => $this->faker->randomFloat(4, 0, 360),
            'azimuth' => $this->faker->randomFloat(4, 0, 360),
        ];
    }
}
