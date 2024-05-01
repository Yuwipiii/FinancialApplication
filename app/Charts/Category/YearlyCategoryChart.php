<?php

namespace App\Charts\Category;

use App\Models\Category;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyCategoryChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $categoryId): array
    {
        $expensesCategory = Category::with('expenses')->where('id', $categoryId)->first();
        $expensesData = [];
        $currentYear = now()->format('Y');
        $months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        $expenses = $expensesCategory->expenses;
        foreach ($months as $key => $month) {
            $startOfMonth = now()->setMonth($key + 1)->startOfMonth();
            $endOfMonth = now()->setMonth($key + 1)->endOfMonth();
            $expensesData[] = round($expenses->whereBetween('date', [$startOfMonth, $endOfMonth])->pluck('amount')->sum(), 2);
        }
        $limit = $expensesCategory->monthly_limit;

        return $this->chart->lineChart()
            ->setTitle('Expenses for '.$currentYear)
            ->addData('Expenses',$expensesData)
            ->addLine("Limit",array_fill(0,12,$limit))
            ->setXAxis(["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"])
            ->setGrid('#3F51B5', 0.2)
            ->setMarkers(['#FF5722', '#E040FB'], 4, 10)
            ->setColors(['#00BA25','#FF3D00'])
            ->toVue();
    }
}
