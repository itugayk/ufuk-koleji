<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'level_id', 'level_name',
        'student_first_name', 'student_last_name', 'student_birth_date',
        'student_gender', 'current_school',
        'parent_name', 'parent_relation', 'parent_phone', 'parent_email',
        'city', 'address', 'message',
        'status', 'admin_notes',
    ];

    protected $casts = [
        'student_birth_date' => 'date',
    ];

    public const STATUSES = [
        'yeni' => 'Yeni',
        'gorusuldu' => 'Görüşüldü',
        'beklemede' => 'Beklemede',
        'kabul' => 'Kabul Edildi',
        'red' => 'Reddedildi',
    ];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function getStudentFullNameAttribute(): string
    {
        return trim($this->student_first_name.' '.$this->student_last_name);
    }
}
