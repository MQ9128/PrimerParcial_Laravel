<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'car_make' => $this->faker->randomElement(['Toyota','Honda','Ford','Chevrolet','Nissan','BMW']),
            'car_model' => $this->faker->word(),
            'car_year' => $this->faker->numberBetween(1990, 2024),
            'car_price' => $this->faker->randomFloat(2, 1000, 800000),
            'car_status' => $this->faker->boolean(80), // 80% chance of being true
            'barcode' => (string) $this->faker->numerify('############'), // ejemplo: dígitos
            'category_id' => Category::inRandomOrder()->value('id') ?? Category::factory(),
        ];
    }
}
