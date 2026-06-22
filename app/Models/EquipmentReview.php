<?php

namespace App\Models;

use App\Support\AchievementPoints;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class EquipmentReview extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (EquipmentReview $review): void {
            if ($review->is_approved && ! $review->video_file) {
                $review->is_approved = false;
            }

            if ($review->is_approved && ! $review->approved_at) {
                $review->approved_at = now();
            }

            if (! $review->is_approved) {
                $review->approved_at = null;
            }
        });

        static::deleting(function (EquipmentReview $review): void {
            Storage::disk('public')->delete(array_filter([
                $review->cover_image,
                $review->video_file,
            ]));
        });

        static::saved(function (EquipmentReview $review): void {
            if ($review->is_approved && $review->wasChanged('is_approved')) {
                AchievementPoints::awardOnce(
                    $review->user_id,
                    'equipment_published',
                    $review,
                    'Опубліковано огляд обладнання: ' . $review->title
                );
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCoverUrlAttribute(): ?string
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        $videoId = $this->youtubeVideoId();

        return $videoId ? "https://i.ytimg.com/vi/{$videoId}/hqdefault.jpg" : null;
    }

    protected function youtubeVideoId(): ?string
    {
        $patterns = [
            '~youtu\.be/([a-zA-Z0-9_-]{6,})~',
            '~youtube\.com/(?:watch\?v=|embed/|shorts/)([a-zA-Z0-9_-]{6,})~',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $this->video_url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
