<?php

namespace Database\Seeders;

use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class ProductSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 4) as $index) {
            $size=product_size($index-1);
                ProductSize::create([
                    "name" => $size,
                ]);
            }
    }
}
