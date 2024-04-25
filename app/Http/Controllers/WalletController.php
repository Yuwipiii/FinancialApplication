<?php

namespace App\Http\Controllers;

use App\Charts\Wallet\MonthlyWalletExpensesChart;
use App\Charts\Wallet\MonthlyWalletIncomesChart;
use App\Charts\Wallet\WeeklyWalletExpenseIncomesChart;
use App\Charts\Wallet\YearlyWalletExpensesChart;
use App\Charts\Wallet\YearlyWalletIncomesChart;
use App\Http\Requests\Walllet\WalletCreateRequest;
use App\Http\Requests\Walllet\WalletUpdateRequest;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;


class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $wallets = Wallet::with('user')->where('user_id',Auth::id())->paginate(2);
        $types = Wallet::TYPES;
        return Inertia::render('Wallets/WalletList',['wallets'=>$wallets,'types'=>$types]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WalletCreateRequest $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $wallet = new Wallet($request->validated());
        $wallet->user_id = Auth::id();
        $wallet->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id,YearlyWalletExpensesChart $yearlyWalletExpensesChart,YearlyWalletIncomesChart $yearlyWalletIncomesChart,WeeklyWalletExpenseIncomesChart $weeklyWalletExpenseIncomesChart,MonthlyWalletExpensesChart $monthlyWalletExpensesChart,MonthlyWalletIncomesChart $monthlyWalletIncomesChart): Response
    {
        $wallet = Wallet::with('user')->where('id',$id)->first();
        $types = Wallet::TYPES;
        $currentMonth = now()->format("F Y");
        $incomes = Income::with('wallet', 'income_category')->where('user_id', Auth::id())->where('wallet_id',$id)->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $incomesSum = $incomes->pluck('amount')->sum();
        $expenses = Expense::with('wallet', 'category')->where('user_id', Auth::id())->where('wallet_id',$id)->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        $expensesSum = $expenses->pluck("amount")->sum();
        return Inertia::render('Wallets/WalletsShow',['yearlyWalletExpensesChart'=>$yearlyWalletExpensesChart->build(Auth::id(),$id),'yearlyWalletIncomesChart'=>$yearlyWalletIncomesChart->build(Auth::id(),$id),'weeklyWalletExpenseIncomesChart'=>$weeklyWalletExpenseIncomesChart->build(Auth::id(),$id),'monthlyWalletIncomesChart'=>$monthlyWalletIncomesChart->build(Auth::id(),$id),'monthlyWalletExpensesChart'=>$monthlyWalletExpensesChart->build(Auth::id(),$id),'expenses'=>$expenses,'expensesSum'=>$expensesSum,'incomes'=>$incomes,'incomesSum'=>$incomesSum,'currentMonth'=>$currentMonth,'wallet'=>$wallet,'types'=>$types]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WalletUpdateRequest $request, string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $wallet = Wallet::find($id);
        $wallet->update($request->validated());
        return redirect(route('wallets.show',$wallet->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        Wallet::with('user')->where('id','=',$id)->where('user_id',Auth::id())->first()->delete();
        return redirect(route('wallets.index'));
    }
}
