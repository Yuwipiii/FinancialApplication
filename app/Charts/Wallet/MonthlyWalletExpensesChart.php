<?php

namespace App\Charts\Wallet;

use App\Models\Category;
use App\Models\Expense;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyWalletExpensesChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $id,string $walletId): array
    {
        $expensesCategory = Category::with('expenses')->where('user_id', $id)->get();
        $expensesData = [];
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        foreach ($expensesCategory as $category) {
            $expenses = $category->expenses;
            $expensesData[] = round($expenses->where('wallet_id',$walletId)->whereBetween('date', [$startOfMonth, $endOfMonth])->pluck('amount')->sum(),2);
        }
        $expensesCategory = $expensesCategory->pluck('name')->toArray();
        $expensesCategory[] = "Other";
        $expensesData[] = round(Expense::with('category')->where('user_id',$id)->where('wallet_id',$walletId)->where('category_id',null)->whereBetween('date', [$startOfMonth, $endOfMonth])->pluck('amount')->sum(),2);
        return $this->chart->pieChart()
            ->setTitle('Expenses for' . now()->format("F Y"))
            ->addData($expensesData)
            ->setLabels($expensesCategory)
            ->toVue();
    }
}
