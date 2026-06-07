<?php

namespace App\Models;

use App\Models\Concerns\HasCoverImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use InteractsWithMedia, HasCoverImage {
        HasCoverImage::registerMediaCollections insteadof InteractsWithMedia;
    }

    protected $fillable = [
        'title', 'slug', 'description', 'location',
        'starts_at', 'ends_at', 'image_path', 'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Event $event) {
            if (blank($event->slug) && filled($event->title)) {
                $event->slug = Str::slug($event->title);
            }
        });
    }

    public function scopeUpcoming($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '>=', now()->startOfDay())
            ->orderBy('starts_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
