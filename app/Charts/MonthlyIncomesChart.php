<?php

namespace App\Charts;

use App\Models\Income;
use App\Models\IncomeCategory;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyIncomesChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $id): array
    {
        $incomesCategory = IncomeCategory::with('incomes')->where('user_id', $id)->get();
        $incomesData= [];
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        foreach ($incomesCategory as $category) {
            $incomes = $category->incomes;
            $incomesData[] = round($incomes->whereBetween('date', [$startOfMonth, $endOfMonth])->pluck('amount')->sum(), 2);
        }
        $incomesCategory = $incomesCategory->pluck('name')->toArray();
        $incomesCategory[] = "Other";
        $incomesData[] = round(Income::with('income_category')->where('user_id',$id)->where('income_category_id',null)->whereBetween('date', [$startOfMonth, $endOfMonth])->pluck('amount')->sum(),2);
        return $this->chart->pieChart()
            ->setTitle('Incomes for' . now()->format("F Y"))
            ->addData($incomesData)
            ->setLabels($incomesCategory)
            ->toVue();
    }
}
