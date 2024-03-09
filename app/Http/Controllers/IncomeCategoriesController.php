<?php

namespace App\Http\Controllers;

use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class IncomeCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $incomeCategories = IncomeCategory::with('user')->where('user_id',Auth::id())->paginate(2);
        return Inertia::render('IncomeCategory/IncomeCategoryList',['incomeCategories'=>$incomeCategories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $incomeCategory = IncomeCategory::with('user')->where('user_id',Auth::id())->where('id',$id)->delete();
        return redirect(route('incomeCategories.index'));
    }
}
