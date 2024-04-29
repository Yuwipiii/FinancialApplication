<?php

use App\Http\Controllers\GoalsController;
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

Route::get('/', function () {
    return Inertia::render('Welcome');
})->middleware('guest');
Route::middleware('auth')->group(function () {
Route::resource('wallets', \App\Http\Controllers\WalletController::class)->except(['edit', 'create'])->middleware(['auth', 'verified']);

Route::get('/', [\App\Http\Controllers\DashboardController::class, 'dashboard'])->name('dashboard');
Route::post('/expenses/create', [\App\Http\Controllers\DashboardController::class, 'createExpense'])->name('expenses.create');
Route::post('/incomes/create', [\App\Http\Controllers\DashboardController::class, 'createIncome'])->name('incomes.create');

Route::resource('categories', \App\Http\Controllers\CategoriesController::class)->except('edit', 'create');
Route::resource('incomeCategories', \App\Http\Controllers\IncomeCategoriesController::class)->except('edit', 'create');
Route::resource('goals', \App\Http\Controllers\GoalsController::class)->except('edit', 'create');


Route::resource('incomes', \App\Http\Controllers\IncomesController::class)->except(['create', 'show', 'edit']);
Route::resource('expenses', \App\Http\Controllers\ExpensesController::class)->except(['create', 'show', 'edit']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
