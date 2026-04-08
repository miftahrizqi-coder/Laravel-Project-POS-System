<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> $this->faker->words(2, true),
            'sku' => Str::upper(Str::random(10)),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'status' => 'active',
        ];
    }
}
