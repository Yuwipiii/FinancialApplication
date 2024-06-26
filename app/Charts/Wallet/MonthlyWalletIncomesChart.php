<?php

namespace App\Charts\Wallet;

use App\Models\Income;
use App\Models\IncomeCategory;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class MonthlyWalletIncomesChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $id,string $walletId): array
    {
        $incomesCategory = IncomeCategory::with('incomes')->where('user_id', $id)->get();
        $incomesData= [];
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        foreach ($incomesCategory as $category) {
            $incomes = $category->incomes;
            $incomesData[] = round($incomes->where('wallet_id',$walletId)->whereBetween('date', [$startOfMonth, $endOfMonth])->pluck('amount')->sum(), 2);
        }
        $incomesCategory = $incomesCategory->pluck('name')->toArray();
        return $this->chart->pieChart()
            ->setTitle('Incomes for' . now()->format("F Y"))
            ->addData($incomesData)
            ->setLabels($incomesCategory)
            ->setFontColor('#e5e7eb')
            ->toVue();
    }
}
