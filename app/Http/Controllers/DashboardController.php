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
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function dashboard(): Response
    {
        $wallets = Wallet::with('user')->where('user_id', Auth::id())->get();
        $netWorthKGS = number_format(array_sum($wallets->where('currency', 'KGS')->pluck('balance')->toArray()), 2, '.', ' ');
        $netWorthUSD = number_format(array_sum($wallets->where('currency', 'USD')->pluck('balance')->toArray()), 2, '.', ' ');
        $categories = Category::with('user')->where('user_id', Auth::id())->get();
        $currencies = Currency::all();
        $incomeCategories = IncomeCategory::with('user')->where('user_id', Auth::id())->get();
        $incomes = Income::with('currency', 'wallet', 'income_category')->where('user_id', Auth::id())->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $transfers = Transfer::with('currency', 'fromWallet', 'toWallet')->where('user_id', Auth::id())->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $expenses = Expense::with('currency', 'wallet', 'category')->where('user_id', Auth::id())->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        return Inertia::render('Dashboard', ['incomeCategories' => $incomeCategories, 'wallets' => $wallets, 'netWorthKGS' => $netWorthKGS, 'netWorthUSD' => $netWorthUSD, 'transfers' => $transfers, 'expenses' => $expenses, 'incomes' => $incomes, 'categories' => $categories, 'currencies' => $currencies]);
    }

    public function createExpense(ExpenseCreateRequest $request): RedirectResponse
    {
        $expense = new Expense($request->validated());
        $expense->user_id = Auth::id();
        $expense->save();
        $wallet = $expense->wallet;
        $wallet->balance -= $this->convert($expense->amount, $expense->currency->base, $wallet->currency->base);
        $wallet->update();
        return redirect(RouteServiceProvider::HOME);
    }

    public function createTransfer(TransferCreateRequest $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $transfer = new Transfer($request->validated());
        $transfer->user_id = Auth::id();
        $fromWallet = $transfer->fromWallet;
        $toWallet = $transfer->toWallet;
        $fromWallet->balance -= $this->convert($transfer->amount, $transfer->currency->base, $fromWallet->currency->base);
        $toWallet->balance += $this->convert($transfer->amount, $transfer->currency->base, $toWallet->currency->base);
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
        $toWallet->balance += $this->convert($income->amount, $income->currency, $toWallet->currency);
        $toWallet->update();
        $income->save();
        return redirect(RouteServiceProvider::HOME);
    }

    private function convert($amount, $fromCurrency, $toCurrency): float|int
    {
        if ($fromCurrency == $toCurrency) {
            return $amount;
        }
        return $amount * $toCurrency->mid;

    }
}
