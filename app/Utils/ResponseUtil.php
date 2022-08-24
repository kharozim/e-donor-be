<?php

namespace App\Utils;

class ResponseUtil
{
    public static function success($data)
    {
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public static function error($message, $code)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ],  $code);
    }
}
