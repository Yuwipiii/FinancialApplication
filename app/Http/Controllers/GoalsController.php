<?php

namespace App\Http\Controllers;

use App\Http\Requests\GoalCreateRequest;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class GoalsController extends Controller
{
    public function index(): \Inertia\Response
    {
        $goals = Goal::with('user')->where('user_id', Auth::id())->paginate(2);
        return Inertia::render('Goals/GoalsList',['goals'=>$goals]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GoalCreateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $goal = new Goal($request->validated());
        $goal->user_id = Auth::id();
        $goal->current_amount = 0;
        $goal->save();
        return redirect(route('goals.index'));
    }

}
