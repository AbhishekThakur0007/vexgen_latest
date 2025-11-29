<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\XP\XPService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class XPNotificationController extends Controller
{
    public function __construct(
        private XPService $xpService
    ) {}

    /**
     * Get pending XP notifications
     */
    public function getPending(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['notifications' => []], 200);
        }

        $notifications = $this->xpService->getPendingNotifications($user, 5);

        return response()->json([
            'notifications' => $notifications->map(function ($xp) {
                return [
                    'id' => $xp->id,
                    'xp_amount' => $xp->xp_amount,
                    'message' => $xp->message,
                    'source_type' => $xp->source_type,
                    'source_id' => $xp->source_id,
                    'created_at' => $xp->created_at->toIso8601String(),
                ];
            }),
        ]);
    }

    /**
     * Mark notification as shown
     */
    public function markAsShown(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        $xpId = $request->input('xp_id');
        $xp = \App\Models\UserXP::where('id', $xpId)
            ->where('user_id', $user->id)
            ->first();

        if ($xp) {
            $xp->markAsShown();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Mark notification as dismissed
     */
    public function markAsDismissed(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        $xpId = $request->input('xp_id');
        $xp = \App\Models\UserXP::where('id', $xpId)
            ->where('user_id', $user->id)
            ->first();

        if ($xp) {
            $xp->markAsDismissed();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    /**
     * Get total XP
     */
    public function getTotalXP(Request $request): JsonResponse
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['total_xp' => 0], 200);
        }

        $totalXP = $this->xpService->getTotalXP($user);

        return response()->json(['total_xp' => $totalXP]);
    }
}
