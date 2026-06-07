<?php

namespace App\Models;

use App\Models\Concerns\HasCoverImage;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class GalleryItem extends Model implements HasMedia
{
    use InteractsWithMedia, HasCoverImage {
        HasCoverImage::registerMediaCollections insteadof InteractsWithMedia;
    }

    protected $fillable = ['title', 'category', 'image_path', 'sort', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'sort' => 'integer'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort');
    }
}
