<?php

namespace Database\Factories;

use COM;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * The commission percentage for the sale.
     *
     * @var float
     */
    const COMMISSION_PCT = 0.085;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $value = $this->faker->randomFloat(2, 50, 500);
        $commission = floor($value * self::COMMISSION_PCT * 100) / 100;

        return [
            'seller_id' => $this->faker->numberBetween(1, 10),
            'value' => $value,
            'sale_date' => $this->faker->dateTimeBetween('-2 weeks', 'now'),
            'created_by_id' => 1,
            'commission' => $commission,
            'reported' => false,
        ];
    }
}
