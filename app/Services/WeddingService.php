<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wedding;
use App\Models\WeddingSegment;
use App\Notifications\WeddingInvitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WeddingService
{
    public function getUserWedding(?int $userId = null)
    {
        $userId = $userId ?? Auth::id();

        return Wedding::with('segments')
            ->where('groom_id', $userId)
            ->orWhere('bride_id', $userId)
            ->first();
    }

    public function createWedding(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = Auth::user();
            $groomId = ($data['role'] === 'groom') ? $user->id : null;
            $brideId = ($data['role'] === 'bride') ? $user->id : null;

            $wedding = Wedding::create([
                'title'    => $data['title'],
                'date'     => $data['date'],
                'groom_id' => $groomId,
                'bride_id' => $brideId,
                'status'   => 'pending',
                'partner_email' => $data['partner_email'],
                'invitation_token' => Str::random(40),
            ]);

            if (isset($data['segments']) && is_array($data['segments'])) {
                foreach ($data['segments'] as $segmentName) {
                    WeddingSegment::create([
                        'wedding_id' => $wedding->id,
                        'name' => $segmentName
                    ]);
                }
            }

            $partner = User::where('email', $data['partner_email'])->first();

            if ($partner) {
                $partner->notify(new WeddingInvitation($wedding, $user->name));
            }

            return $wedding;
        });
    }

    public function acceptInvitation(string $token)
    {
        $user = Auth::user();

        $wedding = Wedding::where('invitation_token', $token)
            ->where('status', 'pending')
            ->firstOrFail();

        if ($wedding->partner_email !== $user->email) {
            throw new \Exception('Undangan ini bukan ditujukan kepadan Anda.');
        }

        DB::transaction(function () use ($wedding, $user) {
            if (is_null($wedding->groom_id)) {
                $wedding->groom_id = $user->id;
            } else {
                $wedding->bride_id = $user->id;
            }

            $wedding->update([
                'status' => 'active',
                'invitation_token' => null
            ]);
        });

        return $wedding;
    }

    public function addSegment($weddingId, $name)
    {
        return WeddingSegment::create(['wedding_id' => $weddingId, 'name' => $name]);
    }

    public function deleteSegment($segmentId)
    {
        WeddingSegment::findOrFail($segmentId)->delete();
    }
}
