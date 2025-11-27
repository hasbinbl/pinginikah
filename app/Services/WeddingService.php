<?php

namespace App\Services;

use App\Models\Wedding;
use Illuminate\Support\Facades\Auth;

class WeddingService
{
    public function getUserWedding(?int $userId = null)
    {
        $userId = $userId ?? Auth::id();

        return Wedding::where('groom_id', $userId)
            ->orWhere('bride_id', $userId)
            ->first();
    }
}
