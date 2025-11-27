<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingItem extends Model
{
    protected $guarded = ['id'];

    public const TYPE_GOLD = 'gold';
    public const TYPE_GENERAL = 'general';

    protected $casts = [
        'is_complete' => 'boolean',
        'fixed_price' => 'double',
        'gold_weight' => 'double',
        'estimated_price' => 'double',
        'completed_at' => 'datetime',
    ];

    public function isGold()
    {
        return $this->type === self::TYPE_GOLD;
    }

    public function segment()
    {
        return $this->belongsTo(WeddingSegment::class, 'wedding_segment_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
