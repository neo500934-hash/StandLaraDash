<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * All categories ordered depth-first (parents before their children),
     * each with a runtime `depth` property for indenting nested options.
     *
     * @param  int|null  $excludeId  A category (and its descendants) to leave out, e.g. when editing itself.
     */
    public static function flattenedTree(?int $excludeId = null): Collection
    {
        $grouped = static::orderBy('name')->get()->groupBy('parent_id');

        $flatten = function ($parentId, int $depth) use (&$flatten, $grouped, $excludeId) {
            return $grouped->get($parentId, collect())
                ->when($excludeId, fn (Collection $categories) => $categories->reject(fn (Category $category) => $category->id === $excludeId))
                ->flatMap(function (Category $category) use ($flatten, $depth) {
                    $category->depth = $depth;

                    return collect([$category])->merge($flatten($category->id, $depth + 1));
                });
        };

        return $flatten(null, 0);
    }
}
