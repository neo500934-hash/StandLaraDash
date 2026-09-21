<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromotionalPrice extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'variant_id',
        'promo_price',
        'starts_at',
        'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'promo_price' => 'decimal:2',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('starts_at', '<=', now())->where('ends_at', '>=', now());
    }
}
