<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => 'Coupon ' . \fake()->unique()->name(),
            'type' => 'money',
            'value' => 20,
            'expired' => \now()->addDays(\random_int(1, 7)),
        ];
    }
}
