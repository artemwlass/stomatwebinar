<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ClinicalCase extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'media' => 'array',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::deleting(function (ClinicalCase $case): void {
            Storage::disk('public')->delete($case->media ?? []);
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ClinicalCaseComment::class);
    }

    public function isVideo(?string $path): bool
    {
        return in_array(strtolower(pathinfo((string) $path, PATHINFO_EXTENSION)), [
            'mp4',
            'mov',
            'webm',
            'm4v',
        ], true);
    }
}
