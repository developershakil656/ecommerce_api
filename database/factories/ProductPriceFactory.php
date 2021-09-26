<?php

namespace Database\Factories;

use App\Models\ProductPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPriceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(1,10),
            'cost_price' => rand(100,500),
            'retail_price' => rand(1000,5000),
            'discount_price' => rand(500,1000),
            'discount_start' => $this->faker->date(),
            'discount_end' => $this->faker->date(),
        ];
    }
}
