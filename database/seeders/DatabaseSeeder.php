<?php

namespace Database\Seeders;

use App\Models\ProductSize;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            ProductSizeSeeder::class
        ]);
        \App\Models\Admin::factory(4)->create();
        // \App\Models\User::factory(10)->create();
        // \App\Models\Post::factory(15)->create();
        \App\Models\Category::factory(15)->create();
        \App\Models\SubCategory::factory(20)->create();

        \App\Models\Product::factory(10)->create();
        \App\Models\ProductColor::factory(5)->create();
        \App\Models\ProductStock::factory(10)->create();
        \App\Models\ProductPrice::factory(10)->create();
    }
}
