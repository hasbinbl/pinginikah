<?php

namespace App\Services;

use App\Models\GoldPrice;
use Illuminate\Support\Facades\Http;

class GoldPriceService
{
    public function syncGoldPrice(): array
    {
        $goldPrice = GoldPrice::first();

        if ($goldPrice && $goldPrice->updated_at->isToday()) {
            return [
                'status'  => 'warning',
                'message' => 'Data sudah diupdate hari ini.'
            ];
        }

        $apiKey = env('METAL_PRICE_API_KEY');

        try {
            $response = Http::timeout(10)->get('https://api.metalpriceapi.com/v1/latest', [
                'api_key'    => $apiKey,
                'base'       => 'USD',
                'currencies' => 'XAU,IDR'
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['rates']['XAU']) && isset($data['rates']['IDR'])) {
                    $rateXau = $data['rates']['XAU'];
                    $rateIdr = $data['rates']['IDR'];

                    $pricePerOunceInIdr = (1 / $rateXau) * $rateIdr;
                    $pricePerGram = $pricePerOunceInIdr / 31.1035;

                    if ($goldPrice) {
                        $goldPrice->price_per_gram = $pricePerGram;
                        $goldPrice->updated_at = now();
                        $goldPrice->save();
                    } else {
                        GoldPrice::create([
                            'price_per_gram' => $pricePerGram
                        ]);
                    }

                    return [
                        'status'  => 'success',
                        'message' => 'Harga emas berhasil diperbarui!'
                    ];
                }
            }

            return [
                'status'  => 'error',
                'message' => 'Gagal mengambil data dari API (Invalid Response).'
            ];
        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => 'Gagal koneksi ke API: ' . $e->getMessage()
            ];
        }
    }
}
