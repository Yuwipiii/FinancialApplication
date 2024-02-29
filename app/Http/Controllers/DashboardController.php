<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard(): \Inertia\Response
    {
        $wallets = Wallet::with('user')->where('user_id',Auth::id())->get();
        $netWorthKGS =array_sum($wallets->where('currency','KGS')->pluck('balance')->toArray());
        $netWorthUSD =array_sum($wallets->where('currency','USD')->pluck('balance')->toArray());
        return Inertia::render('Dashboard',['wallets'=>$wallets,'netWorthKGS'=>$netWorthKGS,'netWorthUSD'=>$netWorthUSD]);
    }
}
