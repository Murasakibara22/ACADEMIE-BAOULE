<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller 
{
    use AuthorizesRequests, ValidatesRequests;

    public function responseError($message, $code=400)
    {
        return response()->json([
            'code' => $code,
            'success' => false,
            'message' => $message,
        ], $code);
    }

    public function responseSuccessMessage($message, $code = 200)
    {
        return response()->json([
            'code' => $code,
            'success' => true,
            'message' => $message,
        ], $code);
    }

    public function responseSuccess($data, $code = 200)
    {
        return response()->json([
            'code' => $code,
            'success' => true,
            'data' => $data,
        ], $code);
    }
}
