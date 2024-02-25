<?php

namespace App\Http\Controllers;

use App\Http\Requests\Walllet\WalletCreateRequest;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;


class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $wallets = Wallet::with('user')->where('user_id',Auth::id())->get();
        return Inertia::render('Wallets/WalletList',['wallets'=>$wallets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $types = Wallet::TYPES;
        $currencies = Wallet::CURRENCIES;
        return Inertia::render('Wallets/WalletsCreate',['types'=>$types,'currencies'=>$currencies]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WalletCreateRequest $request): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $wallet = new Wallet($request->validated());
        $wallet->user_id = Auth::id();
        $wallet->save();
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        Wallet::with('user')->where('id','=',$id)->where('user_id',Auth::id())->first()->delete();
        return redirect(RouteServiceProvider::HOME);
    }
}
