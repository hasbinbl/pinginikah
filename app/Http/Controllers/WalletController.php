<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wallet\AddBalanceRequest;
use App\Http\Requests\Wallet\StoreWalletRequest;
use App\Http\Requests\Wallet\UpdateWalletRequest;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    protected $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    public function index()
    {
        $title   = 'List Tabungan';
        $wallets = $this->walletService->getCoupleWallets();

        return view('wallet.index', compact('wallets', 'title'));
    }

    public function store(StoreWalletRequest $request)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($data) {
                Wallet::create([
                    'user_id' => auth()->id(),
                    'account_name' => $data['account_name'],
                    'bank_name' => $data['bank_name'],
                    'balance'   => $data['balance'],
                ]);
            });

            return back()->with('success', 'Wallet berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function update(UpdateWalletRequest $request, Wallet $wallet)
    {
        if ($wallet->user_id !== auth()->id()) abort(403);

        $data = $request->validated();

        try {
            DB::transaction(function () use ($wallet, $data) {
                $wallet->update($data);
            });

            return back()->with('success', 'Wallet berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function addBalance(AddBalanceRequest $request, Wallet $wallet)
    {
        if ($wallet->user_id !== auth()->id()) abort(403);

        $data = $request->validated();

        DB::transaction(function () use ($wallet, $data) {
            if ($data['type'] === 'add') {
                $wallet->increment('balance', $data['amount']);
            } else {
                $wallet->decrement('balance', $data['amount']);
            }
        });

        return back()->with('success', 'Saldo berhasil disesuaikan!');
    }

    public function destroy(Wallet $wallet)
    {
        if ($wallet->user_id !== auth()->id()) abort(403);
        $wallet->delete();

        return back()->with('status', 'Wallet berhasil dihapus.');
    }
}
