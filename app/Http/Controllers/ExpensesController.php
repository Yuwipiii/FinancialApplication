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
        $expenses = Expense::with('wallet', 'category')->where('user_id', Auth::id())->get();
        return Inertia::render('Expenses/ExpensesList', ['expenses' => $expenses]);
    }

    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $expense = Expense::with('wallet')->where('user_id', Auth::id())->where('id', $id)->first();
        if ($expense->category?->goal_id != null && $expense->category_id != null) {
            $goal = $expense->category->goal;
            $goal->current_amount -= $expense->amount;
            $goal->update();
        }
        $wallet = $expense->wallet;
        $wallet->balance += $expense->amount;
        $wallet->update();
        $expense->delete();
        return redirect()->back();
    }
}
