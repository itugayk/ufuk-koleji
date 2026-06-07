<?php

namespace App\Models;

use App\Models\Concerns\HasCoverImage;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Achievement extends Model implements HasMedia
{
    use InteractsWithMedia, HasCoverImage {
        HasCoverImage::registerMediaCollections insteadof InteractsWithMedia;
    }

    protected $fillable = [
        'title', 'description', 'value', 'suffix', 'icon',
        'category', 'year', 'is_stat', 'image_path', 'sort', 'is_active',
    ];

    protected $casts = [
        'is_stat' => 'boolean',
        'is_active' => 'boolean',
        'value' => 'integer',
        'year' => 'integer',
        'sort' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort');
    }

    public function scopeStats($query)
    {
        return $query->where('is_stat', true);
    }
}
