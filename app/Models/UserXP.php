<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserXP extends Model
{
    use HasFactory;

    protected $table = 'user_xps';

    protected $fillable = [
        'user_id',
        'xp_amount',
        'source_type',
        'source_id',
        'notification_type',
        'message',
        'notified_at',
    ];

    protected $casts = [
        'notified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function markAsShown(): void
    {
        $this->update([
            'notification_type' => 'shown',
            'notified_at' => now(),
        ]);
    }

    public function markAsDismissed(): void
    {
        $this->update([
            'notification_type' => 'dismissed',
            'notified_at' => now(),
        ]);
    }
}
