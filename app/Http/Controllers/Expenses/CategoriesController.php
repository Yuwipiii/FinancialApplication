<?php

namespace App\Http\Controllers\Expenses;

use App\Charts\Category\YearlyCategoryChart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $categories = Category::with('user')->where('user_id', Auth::id())->paginate(4);
        return Inertia::render('Category/CategoryList', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryCreateRequest $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $category = new Category($request->validated());
        $category->user_id = Auth::id();
        $category->save();
        return redirect(route('categories.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id,YearlyCategoryChart $yearlyCategoryChart): Response
    {
        $category = Category::with('user')->where('id', $id)->where('user_id', Auth::id())->first();
        $categoryTotal = $category->expenses->pluck('amount')->sum();
        $categoryCurrentMonthTotal = $category->expenses->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->pluck('amount')->sum();
        return Inertia::render('Category/CategoryShow', ['yearlyCategoryChart'=>$yearlyCategoryChart->build($id),'categoryCurrentMonthTotal'=>$categoryCurrentMonthTotal,'categoryTotal'=>$categoryTotal,'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $category = Category::find($id);
        $category->update($request->validated());
        return redirect(route('categories.show', $category->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $category = Category::with('user')->where('id', $id)->where('user_id', Auth::id())->first();
        if ($category->goal_id !== null) {
            $category->goal()->delete();
        }
        $category->delete();
        return redirect(route('categories.index'));

    }
}
