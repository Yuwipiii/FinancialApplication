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
        $wallets = Wallet::with('user', 'currency')->where('user_id', Auth::id())->get();
        $currencies = Currency::all();
        $netWorthKGS = number_format(array_sum($wallets->where('currency_id', Currency::where('base', 'KGS')->first()->id)->pluck('balance')->toArray()), 2, '.', ' ');
        $netWorthUSD = number_format(array_sum($wallets->where('currency_id', Currency::where('base', 'USD')->first()->id)->pluck('balance')->toArray()), 2, '.', ' ');
        $categories = Category::with('user')->where('user_id', Auth::id())->get();
        $incomeCategories = IncomeCategory::with('user')->where('user_id', Auth::id())->get();
        $incomes = Income::with('currency', 'wallet', 'income_category')->where('user_id', Auth::id())->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $expenses = Expense::with('currency', 'wallet', 'category')->where('user_id', Auth::id())->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        return Inertia::render('Dashboard', ['incomeCategories' => $incomeCategories, 'wallets' => $wallets, 'netWorthKGS' => $netWorthKGS, 'netWorthUSD' => $netWorthUSD, 'expenses' => $expenses, 'incomes' => $incomes, 'categories' => $categories, 'currencies' => $currencies]);
    }

    public function createExpense(ExpenseCreateRequest $request): RedirectResponse
    {
        $expense = new Expense($request->validated());
        $expense->user_id = Auth::id();
        $expense->save();
        $toWallet = $expense->wallet;
        if ($expense->currency->id == $toWallet->currency->id) {
            $toWallet->balance -= $expense->amount;
        } else {
            $cur = Currency::where('base', $expense->currency->base)->first();
            $toWallet->balance -= $expense->amount * $cur->mid;
        }
        $toWallet->update();
        return redirect(RouteServiceProvider::HOME);
    }

    public function createIncome(IncomeCreateRequest $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $income = new Income($request->validated());
        $income->user_id = Auth::id();
        $toWallet = $income->wallet;
        if ($income->currency->id == $toWallet->currency->id) {
            $toWallet->balance += $income->amount;
        } else {
            $currency = Currency::where('base', $income->currency->base)->first();
            $toWallet->balance += $income->amount * $currency->mid;
        }
        $toWallet->update();
        $income->save();
        return redirect(RouteServiceProvider::HOME);
    }

}
