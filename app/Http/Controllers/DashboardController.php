<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseCreateRequest;
use App\Http\Requests\TransferCreateRequest;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Expense;
use App\Models\Transfer;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard(): \Inertia\Response
    {
        $wallets = Wallet::with('user')->where('user_id', Auth::id())->get();
        $netWorthKGS = array_sum($wallets->where('currency', 'KGS')->pluck('balance')->toArray());
        $netWorthUSD = array_sum($wallets->where('currency', 'USD')->pluck('balance')->toArray());
        $categories = Category::with('user')->where('user_id', Auth::id())->get();
        $currencies = Currency::all();
            return Inertia::render('Dashboard', ['wallets' => $wallets, 'netWorthKGS' => $netWorthKGS, 'netWorthUSD' => $netWorthUSD,'categories'=>$categories,'currencies'=>$currencies]);
    }

    public function createExpense(ExpenseCreateRequest $request): RedirectResponse
    {
        $expense = new Expense($request->validated());
        $expense->user_id = Auth::id();
        $expense->save();
        $wallet =$expense->wallet;
        $wallet->balance -= $expense->amount;
        $wallet->update();
        return redirect(RouteServiceProvider::HOME);
    }

    public function createTransfer(TransferCreateRequest $request)
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
}
