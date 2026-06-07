<?php

namespace App\Models;

use App\Models\Concerns\HasCoverImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Level extends Model implements HasMedia
{
    use InteractsWithMedia, HasCoverImage {
        HasCoverImage::registerMediaCollections insteadof InteractsWithMedia;
    }

    protected $fillable = [
        'name', 'slug', 'tagline', 'age_range', 'summary', 'body',
        'icon', 'color', 'image_path', 'sort', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Level $level) {
            if (blank($level->slug) && filled($level->name)) {
                $level->slug = Str::slug($level->name);
            }
        });
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
