<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Motorcycle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $attachable = $this->attachable();
        return [
            'name' => $this->faker->name(),
            'year' => $this->faker->year(),
            'color' => $this->faker->colorName(),
            'price' => $this->faker->randomDigit(),
            'stock' => $this->faker->randomDigit(),
            'attachable_id' => $attachable::factory(),
            'attachable_type' => $attachable,
        ];
    }

    /**
     * Vehicle's attachable
     */
    public function attachable()
    {
        return $this->faker->randomElement([
            Car::class,
            Motorcycle::class,
        ]);
    }
}
