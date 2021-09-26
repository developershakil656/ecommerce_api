<?php

namespace Database\Factories;

use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductStockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductStock::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => rand(1,10),
            'product_color_id' => rand(1,5),
            'product_size_id' => rand(1,5),
            'stock' => rand(10,50)
        ];
    }
}
