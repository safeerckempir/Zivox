<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{store}', [StoreController::class, 'update'])->name('stores.update');
    
    Route::get('/stores/{store}/accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::get('/stores/{store}/accounts/create', [AccountController::class, 'create'])->name('accounts.create');
    Route::post('/stores/{store}/accounts', [AccountController::class, 'store'])->name('accounts.store');
    
    Route::get('/stores/{store}/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/stores/{store}/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/stores/{store}/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    
    Route::get('/api/stores/list', [StoreController::class, 'list'])->name('api.stores.list');
    Route::get('/api/stores/{store}/accounts/list', [AccountController::class, 'list'])->name('api.accounts.list');
    Route::get('/api/stores/{store}/transactions/list', [TransactionController::class, 'list'])->name('api.transactions.list');
});

require __DIR__.'/auth.php';
