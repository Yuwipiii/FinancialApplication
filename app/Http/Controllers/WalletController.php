<?php

namespace App\Http\Controllers;

use App\Http\Requests\Walllet\WalletCreateRequest;
use App\Http\Requests\Walllet\WalletUpdateRequest;
use App\Models\Currency;
use App\Models\Wallet;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
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
        $wallets = Wallet::with('user','currency')->where('user_id',Auth::id())->paginate(2);
        $types = Wallet::TYPES;
        $currencies = Currency::all();
        return Inertia::render('Wallets/WalletList',['wallets'=>$wallets,'types'=>$types,'currencies'=>$currencies]);
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
    public function show(string $id): Response
    {
        $wallet = Wallet::with('user','currency')->where('id',$id)->first();
        $types = Wallet::TYPES;
        return Inertia::render('Wallets/WalletsShow',['wallet'=>$wallet,'types'=>$types]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WalletUpdateRequest $request, string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        $wallet = Wallet::find($id);
        $wallet->update($request->validated());
        return redirect(route('wallets.show',$wallet->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Application|Redirector|RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        Wallet::with('user')->where('id','=',$id)->where('user_id',Auth::id())->first()->delete();
        return redirect(route('wallets.index'));
    }
}
