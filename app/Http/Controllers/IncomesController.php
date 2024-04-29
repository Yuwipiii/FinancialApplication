<?php

namespace App\Http\Controllers;

use App\Http\Requests\Incomes\IncomeUpdateRequest;
use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IncomesController extends Controller
{
    public function index(): \Inertia\Response
    {
        $incomes = Income::with( 'wallet', 'income_category')->where('user_id',Auth::id())->get();
        return Inertia::render('Incomes/IncomesList',['incomes'=>$incomes]);
    }

    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $income = Income::with('wallet', 'income_category')->where('user_id', Auth::id())->where('id', $id)->first();
        $wallet = $income->wallet;
        $wallet->balance -= $income->amount;
        $wallet->update();
        $income->delete();
        return redirect()->back();
    }

    public function update(Income $income,IncomeUpdateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        $wallet = $income->wallet;
        $wallet->balance -=$income->amount;
        $wallet->balance += $data['amount'];
        $wallet->update();
        $income->update($data);
        return redirect()->back();
    }
}
