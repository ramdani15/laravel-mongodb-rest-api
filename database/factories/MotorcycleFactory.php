<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MotorcycleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'machine' => $this->faker->name(),
            'suspension_type' => $this->faker->name(),
            'transmission_type' => $this->faker->name()
        ];
    }
}
