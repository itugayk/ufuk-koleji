<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['title', 'description', 'icon', 'color', 'sort', 'is_active'];

    protected $casts = ['is_active' => 'boolean', 'sort' => 'integer'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort');
    }
}
