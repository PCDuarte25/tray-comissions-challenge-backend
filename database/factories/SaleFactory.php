<?php

namespace Database\Factories;

use App\Models\Seller;
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
            'seller_id' => Seller::inRandomOrder()->first()->id ?? 1,
            'value' => $value,
            'sale_date' => $this->faker->dateTimeBetween('-2 weeks', 'now'),
            'commission' => $commission,
            'reported' => false,
        ];
    }
}
