<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['key', 'title', 'subtitle', 'icon', 'body', 'sort'];

    public static function byKey(string $key): ?self
    {
        return static::where('key', $key)->first();
    }
}
