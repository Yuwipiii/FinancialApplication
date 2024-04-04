<?php

namespace App\Http\Controllers;

use App\Http\Requests\IncomeCreateRequest;
use App\Models\Income;
use App\Providers\RouteServiceProvider;
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
}
