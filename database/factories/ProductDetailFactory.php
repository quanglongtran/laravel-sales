<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductDetail>
 */
class ProductDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randSize = \random_int(1, 4);
        $size = [
            1 => 'S',
            2 => 'M',
            3 => 'L',
            4 => 'XL',
        ];

        return [
            'size' => $size[$randSize],
            'quantity' => \random_int(1000, 2000),
            'product_id' => \random_int(1, 1000),
        ];
    }
}
