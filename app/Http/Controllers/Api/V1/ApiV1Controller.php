<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ApiV1Controller extends Controller
{
    protected function success($data = []): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $data,
            'message' => 'success',
            'status' => 200
        ]);
    }
    protected function error(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => 'Conversion rate not found',
            'status' => 404,
        ]);
    }
}
