<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function successResponse($data, $message = "Success", $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function errorResponse($message, $code)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}