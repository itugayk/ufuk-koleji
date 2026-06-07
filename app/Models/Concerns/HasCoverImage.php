<?php

namespace App\Models\Concerns;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Görsel kaynağını birleştirir:
 *  1) Yönetici panelinden yüklenen Spatie media ("cover")
 *  2) Seeder / fallback için tutulan harici `image_path` (URL ya da yerel yol)
 */
trait HasCoverImage
{
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')->singleFile();
    }

    public function getImageUrlAttribute(): ?string
    {
        $uploaded = $this->getFirstMediaUrl('cover');
        if ($uploaded !== '') {
            return $uploaded;
        }

        return $this->image_path ?: null;
    }
}
