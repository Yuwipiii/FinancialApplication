<?php

namespace App\Charts\Wallet;

use App\Models\Expense;
use App\Models\Income;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class WeeklyWalletExpenseIncomesChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $id,string $walletId): array
    {
        $weekDays = [];
        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->subDays(6);
        $expenses = [];
        $incomes = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $formattedDate = $date->format('j M Y');
            $weekDays[] = $formattedDate;
            $expensesOfDay = Expense::with('user')
                ->where('user_id', $id)
                ->where('wallet_id',$walletId)
                ->whereDate('date', $date->toDateString())
                ->get();
            $incomesOfDay = Income::with('user')
                ->where('user_id', $id)
                ->where('wallet_id',$walletId)
                ->whereDate('date', $date->toDateString())
                ->get();
            $expenses[] = round($expensesOfDay->sum('amount'), 2);
            $incomes[] = round($incomesOfDay->sum('amount'), 2);
        }

        return $this->chart->horizontalBarChart()
            ->setTitle('Last 7 days')
            ->addData('Expenses', $expenses)
            ->addData('Incomes', $incomes)
            ->setXAxis($weekDays)
            ->setGrid('#3F51B5', 0.3)
            ->setColors(['#FF2D00', '#5ED600'])
            ->setFontColor('#000000')
            ->toVue();
    }
}
