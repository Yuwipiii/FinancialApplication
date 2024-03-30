<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ExpensesController extends Controller
{
    public function index(): \Inertia\Response
    {
        $expenses = Expense::with('currency','wallet','category')->where('user_id',Auth::id())->get();
        return Inertia::render('Expenses/ExpensesList',['expenses'=>$expenses]);
    }

    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $expense = Expense::with('wallet', 'currency')->where('user_id', Auth::id())->where('id', $id)->first();
        $wallet = $expense->wallet;
        $wallet->balance -= $expense->amount;
        $wallet->update();
        $expense->delete();
        return redirect()->back();
    }
}
