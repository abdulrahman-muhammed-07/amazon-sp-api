<?php

namespace App\Helpers\Application;

use Symfony\Component\HttpFoundation\Response;

class ApiResponser
{
    public static function success(array $data)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], Response::HTTP_OK);
    }

    public static function error($code, string $message = '')
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
