<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => rand(1,5),
            'sub_category_id' => rand(1,5),
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'thumbnail' => $this->faker->imageUrl(),
            'on_stock' => rand(10,50),
            'created_by_role' => "creator" || "admin",
            'created_by_id' => rand(1,10),
            'on_stock' => rand(10,50),
        ];
    }
}
