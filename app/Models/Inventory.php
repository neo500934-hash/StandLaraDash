<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    use HasFactory;

    public const CREATED_AT = null;

    protected $table = 'inventory';

    protected $primaryKey = 'variant_id';

    public $incrementing = false;

    protected $fillable = [
        'variant_id',
        'quantity_on_hand',
        'quantity_reserved',
        'reorder_threshold',
    ];

    protected function casts(): array
    {
        return [
            'quantity_on_hand' => 'integer',
            'quantity_reserved' => 'integer',
            'reorder_threshold' => 'integer',
        ];
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    protected function available(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity_on_hand - $this->quantity_reserved,
        );
    }
}
