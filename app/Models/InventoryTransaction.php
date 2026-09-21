<?php

namespace App\Models;

use App\Enums\InventoryChangeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryTransaction extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'variant_id',
        'change_type',
        'quantity_delta',
        'reference_id',
    ];

    protected function casts(): array
    {
        return [
            'change_type' => InventoryChangeType::class,
            'quantity_delta' => 'integer',
        ];
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
