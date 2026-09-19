<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'logo',
        'logo_dark',
        'logo_mobile',
        'logo_mobile_dark',
    ];

    /**
     * Get the single website settings record, creating it if it doesn't exist yet.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([], ['name' => config('app.name')]);
    }
}
