<?php

namespace App\Services\XP;

use App\Models\User;
use App\Models\UserXP;
use Carbon\Carbon;

class XPService
{
    /**
     * Award daily login XP
     */
    public function awardDailyLoginXP(User $user): ?UserXP
    {
        // Check if user already got XP today
        $todayXP = UserXP::where('user_id', $user->id)
            ->where('source_type', 'daily_login')
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($todayXP) {
            return null; // Already got XP today
        }

        // Award 50 XP for daily login
        $xpAmount = 50;
        
        return UserXP::create([
            'user_id' => $user->id,
            'xp_amount' => $xpAmount,
            'source_type' => 'daily_login',
            'source_id' => null,
            'notification_type' => 'pending',
            'message' => 'Daily Login Bonus!',
        ]);
    }

    /**
     * Award generation completion XP
     */
    public function awardGenerationXP(User $user, int $generationId, string $generationType = 'generation'): UserXP
    {
        // Calculate XP based on generation type
        $xpAmount = match($generationType) {
            'text' => 10,
            'image' => 15,
            'voice' => 20,
            'video' => 30,
            default => 10,
        };

        $messages = [
            'text' => 'New Generation Complete!',
            'image' => 'Image Generated!',
            'voice' => 'Voice Synthesis Complete!',
            'video' => 'Video Generated!',
            'default' => 'New Generation Complete!',
        ];

        return UserXP::create([
            'user_id' => $user->id,
            'xp_amount' => $xpAmount,
            'source_type' => 'generation',
            'source_id' => $generationId,
            'notification_type' => 'pending',
            'message' => $messages[$generationType] ?? $messages['default'],
        ]);
    }

    /**
     * Get pending XP notifications for user
     */
    public function getPendingNotifications(User $user, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return UserXP::where('user_id', $user->id)
            ->where('notification_type', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get total XP for user
     */
    public function getTotalXP(User $user): int
    {
        return (int) UserXP::where('user_id', $user->id)->sum('xp_amount');
    }
}

