<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Currency;
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
        $categories = Category::with('user','currency')->where('user_id',Auth::id())->paginate(3);
        $currencies  = Currency::all();
        return Inertia::render('Category/CategoryList',['categories'=>$categories,'currencies'=>$currencies]);
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
    public function show(string $id): Response
    {
        $category = Category::with('user','currency')->where('id',$id)->where('user_id',Auth::id())->first();
        return Inertia::render('Category/CategoryShow',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $category = Category::find($id);
        $category->update($request->validated());
        return redirect(route('categories.show',$category->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $category = Category::with('user')->where('id',$id)->where('user_id',Auth::id())->delete();
        return redirect(route('categories.index'));

    }
}
