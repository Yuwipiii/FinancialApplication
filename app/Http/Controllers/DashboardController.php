<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseCreateRequest;
use App\Http\Requests\IncomeCreateRequest;
use App\Http\Requests\TransferCreateRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Expense;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\Transfer;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function dashboard(): Response
    {
        $wallets = Wallet::with('user')->where('user_id', Auth::id())->get();
        $netWorthKGS = array_sum($wallets->where('currency', 'KGS')->pluck('balance')->toArray());
        $netWorthUSD = array_sum($wallets->where('currency', 'USD')->pluck('balance')->toArray());
        $categories = Category::with('user')->where('user_id', Auth::id())->get();
        $currencies = Currency::all();
        $incomeCategories = IncomeCategory::with('user')->where('user_id', Auth::id())->get();
        return Inertia::render('Dashboard', ['incomeCategories' => $incomeCategories, 'wallets' => $wallets, 'netWorthKGS' => $netWorthKGS, 'netWorthUSD' => $netWorthUSD, 'categories' => $categories, 'currencies' => $currencies]);
    }

    public function createExpense(ExpenseCreateRequest $request): RedirectResponse
    {
        $expense = new Expense($request->validated());
        $expense->user_id = Auth::id();
        $expense->save();
        $wallet = $expense->wallet;
        $wallet->balance -= $expense->amount;
        $wallet->update();
        return redirect(RouteServiceProvider::HOME);
    }

    public function createTransfer(TransferCreateRequest $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $transfer = new Transfer($request->validated());
        $transfer->user_id = Auth::id();
        $fromWallet = $transfer->fromWallet;
        $toWallet = $transfer->toWallet;
        $fromWallet->balance -= $transfer->amount;
        $toWallet->balance -= $transfer->amount;
        $toWallet->update();
        $fromWallet->update();
        $transfer->save();
        return redirect(RouteServiceProvider::HOME);

    }

    public function createIncome(IncomeCreateRequest $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $income = new Income($request->validated());
        $income->user_id = Auth::id();
        $toWallet = $income->wallet;
        $toWallet->balance += $income->amount;
        $toWallet->update();
        $income->save();
        return redirect(RouteServiceProvider::HOME);
    }
}
