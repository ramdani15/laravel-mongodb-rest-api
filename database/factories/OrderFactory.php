<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $orderable = $this->orderable();
        return [
            'quantity' => $this->faker->randomDigit(),
            'total_price' => $this->faker->randomDigit() * 1000,
            'orderable_id' => $orderable::factory(),
            'orderable_type' => $orderable,
            'user_id' => User::factory()
        ];
    }

    /**
     * Order's orderable
     */
    public function orderable()
    {
        return $this->faker->randomElement([
            Vehicle::class,
        ]);
    }
}
