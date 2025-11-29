<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WeddingController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // notif
    Route::get('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markRead');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/refresh-gold', [DashboardController::class, 'updatePrice'])->name('dashboard.refreshGold');

    // wallet
    Route::post('/wallet/{wallet}/add-balance', [WalletController::class, 'addBalance'])->name('wallet.addBalance');
    Route::resource('wallet', WalletController::class)->except(['create', 'show', 'edit']);

    // wedding
    Route::get('/wedding/invitation/{token}', [WeddingController::class, 'viewAcceptInvitation'])
        ->name('wedding.accept-invitation');
    Route::post('/wedding/invitation/{token}', [WeddingController::class, 'processAcceptInvitation'])
        ->name('wedding.accept-process');

    Route::post('/wedding/segment', [WeddingController::class, 'storeSegment'])->name('wedding-segment.store');
    Route::delete('/wedding/segment/{segment}', [WeddingController::class, 'destroySegment'])->name('wedding-segment.destroy');

    Route::resource('wedding', WeddingController::class)->except(['show', 'edit']);

    Route::get('/api/users/search', [UserController::class, 'getUser']);
});

require __DIR__ . '/auth.php';
