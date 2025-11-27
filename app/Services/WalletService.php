<?php

namespace App\Services;

use App\Models\Wedding;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletService
{
    protected $weddingService;

    public function __construct(WeddingService $weddingService)
    {
        $this->weddingService = $weddingService;
    }

    public function getUserWedding(?int $userId = null)
    {
        $userId = $userId ?? Auth::id();

        return Wedding::where('groom_id', $userId)
            ->orWhere('bride_id', $userId)
            ->first();
    }

    public function getCoupleUserIds(?int $userId = null): array
    {
        $userId  = $userId ?? Auth::id();
        $wedding = $this->weddingService->getUserWedding($userId);
        $userIds = [$userId];

        if ($wedding) {
            if ($wedding->groom_id) $userIds[] = $wedding->groom_id;
            if ($wedding->bride_id) $userIds[] = $wedding->bride_id;
        }

        return array_unique($userIds);
    }

    public function getCoupleWallets()
    {
        $userIds = $this->getCoupleUserIds();

        return Wallet::with('user')
            ->whereIn('user_id', $userIds)
            ->get();
    }
}
