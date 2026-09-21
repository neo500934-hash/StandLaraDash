<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'size',
        'variant_label',
        'regular_price',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'regular_price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function promotionalPrices(): HasMany
    {
        return $this->hasMany(PromotionalPrice::class, 'variant_id');
    }

    public function salesEvents(): BelongsToMany
    {
        return $this->belongsToMany(SalesEvent::class, 'sales_event_variant', 'variant_id', 'sales_event_id')
            ->withPivot('event_price');
    }

    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class, 'variant_id');
    }

    public function inventoryTransactions(): HasMany
    {
        return $this->hasMany(InventoryTransaction::class, 'variant_id');
    }

    protected function currentPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                $now = now();

                $eventPrice = $this->salesEvents()
                    ->wherePivotNotNull('event_price')
                    ->where('is_active', true)
                    ->where('starts_at', '<=', $now)
                    ->where('ends_at', '>=', $now)
                    ->first()?->pivot->event_price;

                if ($eventPrice !== null) {
                    return (float) $eventPrice;
                }

                $promoPrice = $this->promotionalPrices()->active()->value('promo_price');

                if ($promoPrice !== null) {
                    return (float) $promoPrice;
                }

                return (float) $this->regular_price;
            },
        );
    }
}
