<?php

namespace App\Charts\Wallet;

use App\Models\Income;
use App\Models\IncomeCategory;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class YearlyWalletIncomesChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $id,string $walletId): array
    {
        $incomesCategory = IncomeCategory::with('incomes')->where('user_id', $id)->get();
        $incomesData = [];
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();
        foreach ($incomesCategory as $category) {
            $incomes = $category->incomes;
            $incomesData[] = round($incomes->where('wallet_id',$walletId)->whereBetween('date', [$startOfYear, $endOfYear])->pluck('amount')->sum(),2);
        }
        $incomesCategory = $incomesCategory->pluck('name')->toArray();
        return $this->chart->pieChart()
            ->setTitle('Incomes for' . now()->format("Y"))
            ->addData($incomesData)
            ->setLabels($incomesCategory)
            ->setGrid('#e5e7eb', 0.3)
            ->setColors(['#FF2D00', '#5ED600'])
            ->setFontColor('#e5e7eb')
            ->toVue();
    }
}
