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
            'price' => $this->faker->randomDigit() * 1000,
            'stock' => $this->faker->randomDigit(),
            'attachable_id' => $attachable['class']::factory(),
            'attachable_type' => $attachable['classname'],
        ];
    }

    /**
     * Vehicle's attachable
     */
    public function attachable()
    {
        return $this->faker->randomElement([
            [
                'classname' => 'Car',
                'class' => Car::class
            ],
            [
                'classname' => 'Motorcycle',
                'class' => Motorcycle::class
            ],
        ]);
    }
}
