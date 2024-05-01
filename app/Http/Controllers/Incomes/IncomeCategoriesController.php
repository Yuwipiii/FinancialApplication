<?php

namespace App\Http\Controllers\Incomes;

use App\Charts\IncomeCategory\YearlyIncomeCategoryChart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\IncomeCategoryRequest;
use App\Models\IncomeCategory;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class IncomeCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $incomeCategories = IncomeCategory::with('user')->where('user_id',Auth::id())->paginate(4);
        return Inertia::render('IncomeCategory/IncomeCategoryList',['incomeCategories'=>$incomeCategories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeCategoryRequest $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $incomeCategory = new IncomeCategory($request->validated());
        $incomeCategory->user_id = Auth::id();
        $incomeCategory->save();
        return redirect(route('incomeCategories.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id,YearlyIncomeCategoryChart $yearlyIncomeCategoryChart): Response
    {
        $incomeCategory = IncomeCategory::with('user')->where('user_id',Auth::id())->where('id',$id)->first();
        $incomeCategoryTotal = $incomeCategory->incomes->pluck('amount')->sum();
        $incomeCategoryCurrentMonthTotal = $incomeCategory->incomes->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->pluck('amount')->sum();
        return Inertia::render('IncomeCategory/IncomeCategoryShow',['yearlyIncomeCategoryChart'=>$yearlyIncomeCategoryChart->build($id),'incomeCategoryTotal'=>$incomeCategoryTotal,'incomeCategory'=>$incomeCategory,'incomeCategoryCurrentMonthTotal'=>$incomeCategoryCurrentMonthTotal]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeCategoryRequest $request, string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $incomeCategory = IncomeCategory::with('user')->where('user_id',Auth::id())->where('id',$id)->first();
        $incomeCategory->update($request->validated());
        return redirect(route('incomeCategories.show',$incomeCategory->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $incomeCategory = IncomeCategory::with('user')->where('user_id',Auth::id())->where('id',$id)->delete();
        return redirect(route('incomeCategories.index'));
    }
}
