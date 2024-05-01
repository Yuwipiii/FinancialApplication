<?php

namespace App\Charts\IncomeCategory;

use App\Models\IncomeCategory;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyIncomeCategoryChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $incomeCategoryId): array
    {
        $incomesCategory = IncomeCategory::with('incomes')->where('id', $incomeCategoryId)->first();
        $incomesData = [];
        $currentYear = now()->format('Y');
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $incomes = $incomesCategory->incomes;
        foreach ($months as $key => $month) {
            $startOfMonth = now()->setMonth($key + 1)->startOfMonth();
            $endOfMonth = now()->setMonth($key + 1)->endOfMonth();
            $incomesData[] = round($incomes->whereBetween('date', [$startOfMonth, $endOfMonth])->pluck('amount')->sum(), 2);
        }

        return $this->chart->lineChart()
            ->setTitle('Incomes for '.$currentYear)
            ->addData('Incomes',$incomesData)
            ->setXAxis(["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"])
            ->setGrid('#3F51B5', 0.2)
            ->setMarkers(['#FF5722', '#E040FB'], 4, 10)
            ->setColors(['#00BA25','#FF3D00'])
            ->toVue();
    }
}
