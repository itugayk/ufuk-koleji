<?php

namespace App\Models;

use App\Models\Concerns\HasCoverImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use InteractsWithMedia, HasCoverImage {
        HasCoverImage::registerMediaCollections insteadof InteractsWithMedia;
    }

    protected $table = 'news';

    protected $fillable = [
        'news_category_id', 'type', 'title', 'slug', 'excerpt', 'body',
        'tags', 'image_path', 'is_featured', 'is_published', 'published_at', 'views',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

    public const TYPES = [
        'haber' => 'Haber',
        'duyuru' => 'Duyuru',
    ];

    protected static function booted(): void
    {
        static::saving(function (News $news) {
            if (blank($news->slug) && filled($news->title)) {
                $news->slug = Str::slug($news->title);
            }
            if ($news->is_published && blank($news->published_at)) {
                $news->published_at = now();
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(NewsCategory::class, 'news_category_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }

    public function getReadingTimeAttribute(): int
    {
        return max(1, (int) ceil(str_word_count(strip_tags((string) $this->body)) / 200));
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
