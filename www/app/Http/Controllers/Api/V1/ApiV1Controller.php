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
    protected function error($message): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => $message,
            'status' => 404,
        ]);
    }
}
