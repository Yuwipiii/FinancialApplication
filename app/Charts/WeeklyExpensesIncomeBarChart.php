<?php

namespace App\Charts;

use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class WeeklyExpensesIncomeBarChart
{
    protected LarapexChart $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(string $id): array
    {
        $user = User::where('id', $id)->first();
        $weekDays = [];
        $currentDate = Carbon::now();
        $startDate = $currentDate->copy()->subDays(6);
        $expenses = [];
        $incomes = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $formattedDate = $date->format('D j-M-Y');
            $weekDays[] = $formattedDate;
            $expensesOfDay = Expense::with('user')
                ->where('user_id', $id)
                ->whereDate('date', $date->toDateString())
                ->get();
            $incomesOfDay = Income::with('user')
                ->where('user_id', $id)
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
            ->setGrid('#3F51B5', 0.1)
            ->toVue();
    }
}
