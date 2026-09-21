<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        Product::all()->each(function (Product $product) {
            ProductVariant::factory()
                ->count(random_int(1, 4))
                ->for($product)
                ->create();
        });
    }
}
