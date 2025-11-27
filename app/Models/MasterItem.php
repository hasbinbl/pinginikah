<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterItem extends Model
{
    protected $guarded = ['id'];

    public const TYPE_GOLD = 'gold';
    public const TYPE_GENERAL = 'general';

    protected $casts = [
        'price' => 'double',
        'gold_weight' => 'double',
    ];

    public static function getTypes()
    {
        return [
            self::TYPE_GOLD,
            self::TYPE_GENERAL,
        ];
    }

    public function isGold()
    {
        return $this->type === self::TYPE_GOLD;
    }

    public function getCurrentEstimatedPriceAttribute()
    {
        if ($this->type === self::TYPE_GENERAL) {
            return $this->price;
        }

        if ($this->type === self::TYPE_GOLD) {
            $latestRate = GoldPrice::latest()->first();

            if (!$latestRate) {
                return 0;
            }

            return $latestRate->price_per_gram * $this->gold_weight;
        }

        return 0;
    }

    public function getFormattedPriceAttribute()
    {
        return formatRupiah($this->current_estimated_price);
    }
}
