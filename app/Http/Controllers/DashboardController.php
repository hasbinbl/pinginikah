<?php

namespace App\Http\Controllers;

use App\Models\GoldPrice;
use App\Services\GoldPriceService;
use App\Services\WalletService;
use App\Services\WeddingService;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    protected $walletService;
    protected $weddingService;
    protected $goldPriceService;

    public function __construct(
        WalletService $walletService,
        WeddingService $weddingService,
        GoldPriceService $goldPriceService
    ) {
        $this->walletService  = $walletService;
        $this->weddingService = $weddingService;
        $this->goldPriceService = $goldPriceService;
    }

    public function index()
    {
        $title = 'Dashboard';

        $goldPrice = GoldPrice::first();

        $isRefreshedToday = $goldPrice && $goldPrice->updated_at->isToday();

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
        $result = $this->goldPriceService->syncGoldPrice();
        return back()->with($result['status'], $result['message']);
    }
}
