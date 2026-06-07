<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class NewsCategory extends Model
{
    protected $fillable = ['name', 'slug', 'color'];

    protected static function booted(): void
    {
        static::saving(function (NewsCategory $cat) {
            if (blank($cat->slug) && filled($cat->name)) {
                $cat->slug = Str::slug($cat->name);
            }
        });
    }

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
