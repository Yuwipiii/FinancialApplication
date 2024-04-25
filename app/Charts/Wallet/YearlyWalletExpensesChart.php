<?php

namespace App\Charts\Wallet;

use App\Models\Category;
use App\Models\Expense;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyWalletExpensesChart
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
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();
        foreach ($expensesCategory as $category) {
            $expenses = $category->expenses;
            $expensesData[] = round($expenses->where('wallet_id',$walletId)->whereBetween('date', [$startOfYear, $endOfYear])->pluck('amount')->sum(),2);
        }
        $expensesCategory = $expensesCategory->pluck('name')->toArray();
        $expensesCategory[] = "Other";
        $expensesData[] = round(Expense::with('category')->where('user_id',$id)->where('wallet_id',$walletId)->where('category_id',null)->whereBetween('date', [$startOfYear, $endOfYear])->pluck('amount')->sum(),2);
        return $this->chart->pieChart()
            ->setTitle('Expenses for' . now()->format("Y"))
            ->addData($expensesData)
            ->setLabels($expensesCategory)
            ->toVue();
    }
}
