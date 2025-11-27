<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wedding extends Model
{
    protected $guarded = ['id'];

    public function segments()
    {
        return $this->hasMany(WeddingSegment::class);
    }

    public function items()
    {
        return $this->hasManyThrough(WeddingItem::class, WeddingSegment::class);
    }
}
