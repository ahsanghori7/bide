<?php

namespace App\Http\Responses;

class ApiResponse
{
    public static function success($data = null, $status = 200)
    {
        return response()->json(['success' => true, 'data' => $data, 'status' => $status], $status);
    }

    public static function error($message, $status = 422)
    {
        return response()->json(['error' => $message, 'status' => $status], $status);
    }
}
