<?php

namespace Database\Seeders;

use App\Models\Inventory;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        ProductVariant::all()->each(function (ProductVariant $variant) {
            Inventory::factory()->for($variant, 'variant')->create();
        });
    }
}
