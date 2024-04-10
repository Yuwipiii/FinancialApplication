<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConvertorController extends ApiV1Controller
{
    public function convert($from,$to,$amount): JsonResponse
    {
        if($from === $to){
            return $this->success($amount);
        }
        $mid = Currency::where('base',$from)->where('counter',$to)->first();
        if($mid === null){
            return $this->error();
        }
        $convertedAmount = round($amount * $mid->mid,2);
        return  $this->success($convertedAmount);
    }
}
