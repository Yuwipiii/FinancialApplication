<?php

namespace App\Charts;

use App\Models\Expense;
use App\Models\Income;
use App\Models\User;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class WeeklyExpensesIncomeBarChart
{
    protected $chart;

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
        $expensesUSD = [];
        $expensesKGS = [];
        $incomesUSD = [];
        $incomesKGS = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $formattedDate = $date->format('D j-M-Y');
            $weekDays[] = $formattedDate;
            $expensesOfDay = Expense::with('currency','user')
                ->where('user_id', $id)
                ->whereDate('date', $date->toDateString())
                ->get();
            $incomesOfDay = Income::with('currency','user')
                ->where('user_id', $id)
                ->whereDate('date', $date->toDateString())
                ->get();
            $expensesUSD[] = $expensesOfDay->where('currency.base', 'USD')->sum('amount');
            $expensesKGS[] = $expensesOfDay->where('currency.base', 'KGS')->sum('amount');
            $incomesKGS[] = $incomesOfDay->where('currency.base', 'KGS')->sum('amount');
            $incomesUSD[] = $incomesOfDay->where('currency.base', 'USD')->sum('amount');
        }
        //TODO Сделать отображение сумм после запятой две

        return $this->chart->barChart()
            ->setTitle('Last 7 days')
            ->addData('Expenses USD', $expensesUSD)
            ->addData('Expenses KGS', $expensesKGS)
            ->addData('Incomes KGS',$incomesKGS)
            ->addData('Incomes USD',$incomesUSD)
            ->setXAxis($weekDays)
            ->toVue();
    }
}
