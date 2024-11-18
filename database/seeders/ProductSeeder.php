<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create(['name' => 'Product A', 'price' => 1000, 'category_id' => 1]);
        Product::create(['name' => 'Product B', 'price' => 5000, 'category_id' => 1]);
        Product::create(['name' => 'Product C', 'price' => 3000, 'category_id' => 2]);
    }
}
