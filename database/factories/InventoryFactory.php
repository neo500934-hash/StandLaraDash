<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inventory>
 */
class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    public function definition(): array
    {
        return [
            'variant_id' => ProductVariant::factory(),
            'quantity_on_hand' => $this->faker->numberBetween(0, 200),
            'quantity_reserved' => 0,
            'reorder_threshold' => $this->faker->numberBetween(5, 20),
        ];
    }
}
