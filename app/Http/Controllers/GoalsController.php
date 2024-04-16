<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalCreateRequest;
use App\Models\Category;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GoalsController extends Controller
{
    public function index(): \Inertia\Response
    {
        $goals = Goal::with('user','category')->where('user_id', Auth::id())->paginate(2);
        return Inertia::render('Goals/GoalList',['goals'=>$goals]);
    }

    public function store(GoalCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $goal = new Goal($request->validated());
        $goal->user_id = Auth::id();
        $goal->current_amount = 0;
        $goal->save();
        $goalCategory = new Category(['name'=>"Expenses for the goal: $goal->name",'user_id'=>Auth::id()]);
        $goalCategory->save();
        $goalCategory->goal()->save($goal);
        $goal->category()->save($goalCategory);
        return redirect(route('goals.index'));
    }

    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $goal = Goal::with('user')->findOrFail($id);
        $goal->category()->delete();
        $goal->delete();
        return redirect()->back();
    }

    public function show(string $id):\Inertia\Response
    {
        $goal = Goal::with('category','user')->where('user_id',Auth::id())->findOrFail($id);
        return Inertia::render('Goals/GoalShow',['goal'=>$goal]); 
    }

    public function update(){ 
        
    }



}
