<?php

namespace App\Http\Controllers;

use App\Charts\MonthlyExpensesChart;
use App\Charts\MonthlyIncomesChart;
use App\Charts\WeeklyExpensesIncomeBarChart;
use App\Charts\YearlyExpensesChart;
use App\Charts\YearlyIncomesChart;
use App\Http\Requests\ExpenseCreateRequest;
use App\Http\Requests\IncomeCreateRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Expense;
use App\Models\Income;
use App\Models\IncomeCategory;
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
    public function dashboard(WeeklyExpensesIncomeBarChart $weeklyExpensesIncomeBarChart,MonthlyExpensesChart $monthlyExpensesChart,MonthlyIncomesChart $monthlyIncomesChart,YearlyIncomesChart $yearlyIncomesChart,YearlyExpensesChart $yearlyExpensesChart): Response
    {
        $userId = Auth::id();
        $wallets = Wallet::with('user')->where('user_id', $userId)->get();
        $currencies = Currency::all();
        $netWorth = number_format(array_sum($wallets->pluck('balance')->toArray()), 2, '.', ' ');
        $categories = Category::with('user')->where('user_id', $userId)->get();
        $incomeCategories = IncomeCategory::with('user')->where('user_id', $userId)->get();
        $incomes = Income::with('wallet', 'income_category')->where('user_id', $userId)->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $incomesSum = $incomes->pluck('amount')->sum();
        $expenses = Expense::with('wallet', 'category')->where('user_id', $userId)->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $expensesSum = $expenses->pluck("amount")->sum();
        $currentMonth = now()->format("F Y");
        return Inertia::render('Dashboard', ['yearlyExpensesChart'=>$yearlyExpensesChart->build($userId),'yearlyIncomesChart'=>$yearlyIncomesChart->build($userId),'monthlyIncomesChart'=>$monthlyIncomesChart->build($userId),'monthlyExpensesChart'=>$monthlyExpensesChart->build($userId),'currentMonth' => $currentMonth, 'expensesSum' => $expensesSum, 'incomesSum' => $incomesSum, 'weeklyExpensesIncomeBarChart' => $weeklyExpensesIncomeBarChart->build($userId), 'incomeCategories' => $incomeCategories, 'wallets' => $wallets, 'netWorth' => $netWorth, 'expenses' => $expenses, 'incomes' => $incomes, 'categories' => $categories, 'currencies' => $currencies]);
    }

    public function createExpense(ExpenseCreateRequest $request): RedirectResponse
    {
        $expense = new Expense($request->validated());
        $expense->user_id = Auth::id();
        $expense->save();
        $toWallet = $expense->wallet;
        $toWallet->balance -= $expense->amount;
        $toWallet->update();
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
