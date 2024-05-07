<?php

namespace App\Charts\Expenses;

use App\Models\Category;
use App\Models\Expense;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyExpensesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $id): array
    {
        $expensesCategory = Category::with('expenses')->where('user_id', $id)->get();
        $expensesData = [];
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();
        foreach ($expensesCategory as $category) {
            $expenses = $category->expenses;
            $expensesData[] = round($expenses->whereBetween('date', [$startOfYear, $endOfYear])->pluck('amount')->sum(),2);
        }
        $expensesCategory = $expensesCategory->pluck('name')->toArray();
        return $this->chart->pieChart()
            ->setTitle('Expenses for ' . now()->format("Y"))
            ->addData($expensesData)
            ->setLabels($expensesCategory)
            ->setFontColor('#e5e7eb')
            ->toVue();
    }
}
