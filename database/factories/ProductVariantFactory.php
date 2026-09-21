<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    protected $model = ProductVariant::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'sku' => strtoupper($this->faker->unique()->bothify('SKU-#####-???')),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', null]),
            'variant_label' => $this->faker->optional()->word(),
            'regular_price' => $this->faker->randomFloat(2, 5, 500),
            'is_active' => true,
        ];
    }
}
