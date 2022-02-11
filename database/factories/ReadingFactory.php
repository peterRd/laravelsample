<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReadingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'depth' => $this->faker->randomFloat(2, 0, 999999),
            'dip' => $this->faker->randomFloat(null, 0, 360),
            'azimuth' => $this->faker->randomFloat(null, 0, 360),
        ];
    }
}
