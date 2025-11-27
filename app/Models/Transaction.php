<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['date' => 'date'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function item()
    {
        return $this->belongsTo(WeddingItem::class, 'wedding_item_id');
    }
}
