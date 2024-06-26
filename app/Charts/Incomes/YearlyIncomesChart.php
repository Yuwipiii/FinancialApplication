<?php

namespace App\Charts\Incomes;

use App\Models\Income;
use App\Models\IncomeCategory;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyIncomesChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $id): array
    {
        $incomesCategory = IncomeCategory::with('incomes')->where('user_id', $id)->get();
        $incomesData = [];
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();
        foreach ($incomesCategory as $category) {
            $incomes = $category->incomes;
            $incomesData[] = round($incomes->whereBetween('date', [$startOfYear, $endOfYear])->pluck('amount')->sum(),2);
        }
        $incomesCategory = $incomesCategory->pluck('name')->toArray();
        return $this->chart->pieChart()
            ->setTitle('Incomes for' . now()->format("Y"))
            ->addData($incomesData)
            ->setLabels($incomesCategory)
            ->setFontColor('#e5e7eb')
            ->toVue();
    }
}
