<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReciprocityController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/campaigns', [CampaignController::class, 'index'])->name('campaigns.index');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::post('/campaigns/{campaign}/complete', [CampaignController::class, 'complete'])->name('campaigns.complete');

    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');
    Route::post('/community/{member}/sync', [CommunityController::class, 'sync'])->name('community.sync');

    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/membership', [MembershipController::class, 'index'])->name('membership.index');
    Route::post('/membership/upgrade', [MembershipController::class, 'upgrade'])->name('membership.upgrade');
    Route::post('/membership/convert-points', [MembershipController::class, 'convertPoints'])->name('membership.convert-points');

    Route::get('/reciprocity', [ReciprocityController::class, 'index'])->name('reciprocity.index');
    Route::post('/reciprocity/{campaign}/complete', [ReciprocityController::class, 'complete'])->name('reciprocity.complete');
    Route::post('/reciprocity/{campaign}/ignore', [ReciprocityController::class, 'ignore'])->name('reciprocity.ignore');
    Route::post('/reciprocity/appeal', [ReciprocityController::class, 'appeal'])->name('reciprocity.appeal');
});

require __DIR__ . '/auth.php';
