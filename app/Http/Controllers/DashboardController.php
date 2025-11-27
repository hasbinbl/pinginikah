<?php

namespace App\Http\Controllers;

use App\Models\GoldPrice;
use App\Models\Wallet;
use App\Services\WalletService;
use App\Services\WeddingService;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    protected $walletService;
    protected $weddingService;

    public function __construct(WalletService $walletService, WeddingService $weddingService)
    {
        $this->walletService  = $walletService;
        $this->weddingService = $weddingService;
    }

    public function index()
    {
        $title = 'Dashboard';

        $goldPrice = GoldPrice::first();

        $isRefreshedToday = false;

        if ($goldPrice && $goldPrice->updated_at->isToday()) {
            $isRefreshedToday = true;
        }

        $wedding = $this->weddingService->getUserWedding();
        $wallets = $this->walletService->getCoupleWallets();

        $totalBalance = $wallets->sum('balance');

        return view('dashboard', compact(
            'title',
            'goldPrice',
            'isRefreshedToday',
            'wallets',
            'totalBalance',
            'wedding'
        ));
    }

    public function updatePrice()
    {
        $goldPrice = GoldPrice::first();

        if ($goldPrice && $goldPrice->updated_at->isToday()) {
            return back()->with('error', 'Data sudah diupdate hari ini.');
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

                    GoldPrice::updateOrCreate(
                        ['id' => 1],
                        ['price_per_gram' => $pricePerGram]
                    );

                    return back()->with('success', 'Harga emas berhasil diperbarui!');
                }
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal koneksi ke API.');
        }
    }
}
