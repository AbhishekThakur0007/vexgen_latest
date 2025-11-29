<?php

namespace App\Observers;

use App\Models\UserOpenai;
use App\Services\XP\XPService;

class UserOpenaiObserver
{
    public function __construct(
        private XPService $xpService
    ) {}

    /**
     * Handle the UserOpenai "created" event.
     * Award XP when generation is created with output (text generations)
     */
    public function created(UserOpenai $userOpenai): void
    {
        // Award XP if output exists (text generations usually have output immediately)
        if ($userOpenai->output && !empty($userOpenai->output)) {
            $this->awardXPForGeneration($userOpenai);
        }
    }

    /**
     * Handle the UserOpenai "updated" event.
     * Award XP when generation is completed
     */
    public function updated(UserOpenai $userOpenai): void
    {
        // Award XP when status changes to COMPLETED (videos/images)
        if ($userOpenai->isDirty('status') && $userOpenai->status === 'COMPLETED') {
            $this->awardXPForGeneration($userOpenai);
        }
        // Also check if output was just added (for text that doesn't use status)
        elseif ($userOpenai->isDirty('output') && $userOpenai->output && !empty($userOpenai->output)) {
            // Check if XP was already awarded for this generation
            $existingXP = \App\Models\UserXP::where('user_id', $userOpenai->user_id)
                ->where('source_type', 'generation')
                ->where('source_id', $userOpenai->id)
                ->exists();
            
            if (!$existingXP) {
                $this->awardXPForGeneration($userOpenai);
            }
        }
    }

    /**
     * Award XP for a generation
     */
    private function awardXPForGeneration(UserOpenai $userOpenai): void
    {
        // Reload relationships if needed
        if (!$userOpenai->relationLoaded('user')) {
            $userOpenai->load('user');
        }
        if (!$userOpenai->relationLoaded('generator')) {
            $userOpenai->load('generator');
        }

        $user = $userOpenai->user;
        if (!$user) {
            return;
        }

        // Check if XP was already awarded for this generation
        $existingXP = \App\Models\UserXP::where('user_id', $user->id)
            ->where('source_type', 'generation')
            ->where('source_id', $userOpenai->id)
            ->exists();
        
        if ($existingXP) {
            return; // Already awarded
        }

        // Determine generation type
        $generationType = 'text';
        if ($userOpenai->generator) {
            $type = $userOpenai->generator->type;
            $generationType = match($type) {
                'image' => 'image',
                'voice' => 'voice',
                'video' => 'video',
                default => 'text',
            };
        }

        $this->xpService->awardGenerationXP(
            $user,
            $userOpenai->id,
            $generationType
        );
    }
}
