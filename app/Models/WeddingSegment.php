<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingSegment extends Model
{
    protected $guarded = ['id'];

    public function items()
    {
        return $this->hasMany(WeddingItem::class);
    }

    public function getTotalEstimatedPriceAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->is_complete ? $item->fixed_price : $item->estimated_price;
        });
    }

    public function getTotalSpentAttribute()
    {
        return $this->items->where('is_complete', true)->sum('fixed_price');
    }

    public function getProgressPercentageAttribute()
    {
        $totalItems = $this->items->count();
        if ($totalItems == 0) return 0;

        $completedItems = $this->items->where('is_complete', true)->count();
        return round(($completedItems / $totalItems) * 100);
    }
}
