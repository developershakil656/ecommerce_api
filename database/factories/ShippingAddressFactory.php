<?php

namespace Database\Factories;

use App\Models\ShippingAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ShippingAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => rand(1,5),
            'number' => $this->faker->phoneNumber(),
            'reciever_name' => $this->faker->name(),
            'region' => $this->faker->country(),
            'city' => $this->faker->city(),
            'area' => $this->faker->name(),
            'address' => $this->faker->address(),
            'label' => rand(0,1),
        ];
    }
}
