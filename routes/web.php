<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',function (){
    return Inertia::render('Welcome');
})->middleware('guest');

Route::resource('wallets', \App\Http\Controllers\WalletController::class)->except(['edit'])->middleware(['auth','verified']);

Route::get('/',[\App\Http\Controllers\DashboardController::class,'dashboard'])->middleware(['auth'])->name('dashboard');
Route::post('/expenses/wallet/create',[\App\Http\Controllers\DashboardController::class,'createExpense'])->middleware(['auth'])->name('expenses.wallet.create');
Route::post('/transfers/wallet/create',[\App\Http\Controllers\DashboardController::class,'createTransfer'])->middleware(['auth'])->name('transfers.wallet.create');
Route::post('/incomes/wallet/create',[\App\Http\Controllers\DashboardController::class,'createIncome'])->middleware(['auth'])->name('incomes.wallet.create');

Route::resource('expenses',\App\Http\Controllers\ExpensesController::class)->middleware(['auth']);
Route::resource('incomes',\App\Http\Controllers\IncomesController::class)->middleware(['auth']);
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
